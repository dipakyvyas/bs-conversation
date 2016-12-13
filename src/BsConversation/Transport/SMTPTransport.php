<?php
namespace BsConversation\Transport;

use BsConversation\Model\DeliveryInterface;
use BsConversation\Service\ConversationService;
use BsConversation\Model\DeliverySMTPInterface;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Message;
use BsConversation\Model\ParticipantSMTPInterface;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Mime;
use BsConversation\Model\MessageInterface;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Filter\StripTags;
use BsConversation\Plugin\UnsubscribeUrl;
use BsConversation\Model\AttachmentEnabledMessageInterface;
use BsFile\Model\Mapper\FileInterface;

/**
 *
 * @author jonasgarbuio
 *
 */
class SMTPTransport implements TransportInterface
{

    /**
     *
     * @var ConversationService
     */
    protected $conversationService;

    /**
     *
     * @var array
     */
    protected $options;

    /**
     *
     * @var UnsubscribeUrl
     */
    protected $unsubscribeUrlPlugin;

    public function __construct(ConversationService $conversationService, UnsubscribeUrl $unsubscribeUrlPlugin)
    {
        $this->conversationService = $conversationService;
        $this->options = $this->conversationService->getTransportOptions('smtp');
        $this->unsubscribeUrlPlugin = $unsubscribeUrlPlugin;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \BsConversation\Transport\TransportInterface::send()
     */
    public function send(DeliveryInterface $delivery)
    {
        if (! $delivery instanceof DeliverySMTPInterface) {
            throw new \Exception('The Delivery doesn\'t implements DeliverySMTPInterface.');
        }

        $transport = new Smtp();

        $options = $this->options['options'];

        $mailOption = new SmtpOptions($options);

        $transport->setOptions($mailOption);

        $mail = new Message();

        if (! $this->options['defaults']['from']) {
            throw new \Exception('No from email configured');
        }
        $mail->addFrom($this->options['defaults']['from']);

        if (! $this->options['defaults']['replyto']) {
            throw new \Exception('No replyto email configured');
        }
        $mail->addReplyTo($this->options['defaults']['replyto']);

        $message = $delivery->getMessage();
        $conversation = $message->getConversation();
        $participants = $conversation->getParticipants();

        if ($this->conversationService->getOptions()->getSubjectIncludeConversationId() && ! strpos($message->getSubject(), $conversation->getId())) {
            $mail->setSubject($message->getSubject() . ' | [===' . $conversation->getId() . '===]');
        } else {
            $mail->setSubject($message->getSubject());
        }

        $sender = $message->getCreatedBy();

        if (! $sender instanceof ParticipantSMTPInterface) {
            throw new \Exception('the email sender doesn\'t implement ParticipantSMTPInterface ');
        }

        if ($delivery->getEmail() == $sender->getEmail() && ! $message->getSendCopy()) {
            // don't send this delivery
            $delivery->setStatus(DeliveryInterface::DELIVERED);
            $this->conversationService->saveDelivery($delivery);
            return false;
        }

        $mail->addTo($delivery->getEmail());
        $generalOptions = $this->conversationService->getOptions()->getGeneralOptions();
        if (boolval($generalOptions['include_reply_line'])) {
            $replyLine = $this->generateReplyLine($message);
            $messageBody = $replyLine . $message->getBody();
        } else {
            $messageBody = $message->getBody();
        }

        if (boolval($generalOptions['unsubscribe_link'])) {
            $link = $this->generateUnsubscribeLink($message, $delivery);
        }

        $messageBody .= ($link ? '<br/><br/><a href="' . $link . '">Unsubscribe</a> from this conversation' : '');
        if (isset($generalOptions['footer'])) {
            $messageBody .= '<br/>' . $generalOptions['footer'];
        }

        $html = new MimePart($messageBody);
        $html->setType(Mime::TYPE_HTML);

        $textPlain = new MimePart((new StripTags())->filter($messageBody) . ($link ? "\n\nTo unsubscribe from this conversation, click the link below.\n\n" . $link : ''));
        $textPlain->setType(Mime::TYPE_TEXT);

        $body = new MimeMessage();
        $body->setParts(array(
            $textPlain,
            $html
        ));

        if ($message instanceof AttachmentEnabledMessageInterface && $message->getAttachments()) {

            foreach ($message->getAttachments() as $attachment) {
                $this->processAttachment($body, $attachment);
            }
        }

        $mail->setBody($body);

        $transport->send($mail);

        $delivery->setStatus(DeliveryInterface::DELIVERED);
        $this->conversationService->saveDelivery($delivery);
    }

    protected function processAttachment(MimeMessage $body, FileInterface $file)
    {
        $attachment = $this->createMimePart($file);

        $body->addPart($attachment);
    }

    /**
     *
     * @param FileInterface $file
     * @return MimePart
     */
    protected function createMimePart(FileInterface $file)
    {
        $fileBytes = $file->getFile()->getBytes();

        $extension = $this->getFileExtensionFromName($file->getName());

        $tmpfname = tempnam('/tmp', $extension);

        file_put_contents($tmpfname, $fileBytes);

        $fileContent = fopen($tmpfname, 'r');

        $attachment = new MimePart($fileContent);
        $attachment->type = $file->getMime();
        $attachment->filename = $file->getName();
        $attachment->disposition = Mime::DISPOSITION_ATTACHMENT;
        $attachment->encoding = Mime::ENCODING_BASE64;

        return $attachment;
    }

    /**
     *
     * @param string $fileName
     * @return string
     */
    protected function getFileExtensionFromName($fileName)
    {
        return substr($fileName, (strrpos($fileName, '.') + 1));
    }

    /**
     *
     * @param MessageInterface $message
     * @param DeliverySMTPInterface $delivery
     * @return string
     */
    public function generateUnsubscribeLink(MessageInterface $message, DeliverySMTPInterface $delivery)
    {
        return $this->unsubscribeUrlPlugin->__invoke($message->getConversation(), $delivery->getEmail());
    }

    /**
     *
     * @param \Zend\Mail\Message $mail
     * @param MessageInterface $message
     */
    public function generateReplyLine(MessageInterface $message)
    {
        $bodyMessage = '[==== Please write your reply above this line ref:#' . $message->getConversation()->getId() . ' ====]';
        $bodyMessage .= "\n\n<br/><br/>";

        return $bodyMessage;
    }

    /**
     *
     * {@inheritDoc}
     *
     * @see \BsConversation\Transport\TransportInterface::createDelivery()
     */
    public function createDelivery(\BsConversation\Model\ParticipantInterface $participant, \BsConversation\Model\MessageInterface $message)
    {
        if (! $message->getCreatedBy() instanceof ParticipantSMTPInterface) {
            throw new \Exception('The Message creator doesn\'t implements ParticipantSMTPInterface.');
        }
        if (! $participant instanceof ParticipantSMTPInterface) {
            throw new \Exception('The participant doesn\'t implements ParticipantSMTPInterface.');
        }

        if ($participant->getEmail() == $message->getCreatedBy()->getEmail() && ! $message->getSendCopy()) {
            // Don't send copy to the sender.
            return null;
        }

        $entity = $this->options['delivery_entity'];

        if (! $entity || ! class_exists($entity)) {
            throw new \Exception('No delivery entity configured');
        }

        $delivery = new $entity();

        if (! $delivery instanceof DeliverySMTPInterface) {
            throw new \Exception('Could not instantiate entity or invalid class. class: ' . $entity);
        }

        $delivery->setMessage($message);
        $delivery->setStatus(DeliveryInterface::PENDING);
        $delivery->setFrom($this->options['defaults']['from']);
        $delivery->setReplyTo($this->options['defaults']['replyto']);
        $delivery->setEmail($participant->getEmail());
        $delivery->setDeliveryTransport('smtp');

        return $delivery;
    }
}