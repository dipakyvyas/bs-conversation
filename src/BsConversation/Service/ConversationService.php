<?php
namespace BsConversation\Service;

use BsConversation\Model\MessageInterface;
use BsConversation\Model\ConversationInterface;
use BsConversation\Model\ParticipantInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use BsConversation\Transport\TransportInterface;
use BsConversation\Model\DeliveryInterface;
use BsConversation\Model\ConversationSubjectInterface;
use BsConversation\Options\Options;
use BsBase\Model\Mapper\MapperInterface;
use Zend\Filter\Word\UnderscoreToCamelCase;
use BsConversation\Event\Manager;
/**
 *
 * @author jonasgarbuio
 *
 */
class ConversationService implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     *
     * @var Options
     */
    protected  $options;

    /**
     *
     * @var MapperInterface
     */
    protected $mapper;

    /**
     *
     * @var Manager
     */
    protected $eventManager;


    /**
     * @return Options
     */
    public function getOptions(){
        return $this->getServiceLocator()->get('bsconversation_options');
    }
    /**
     * @return MapperInterface
     */
    public function getMapper(){
        return $this->getServiceLocator()->get('bsconversation_mapper');
    }

    public function __construct(Options $options, MapperInterface $mapper, Manager $eventManager)
    {
        $this->options = $options;
        $this->mapper = $mapper;
        $this->eventManager = $eventManager;
    }

    /**
     *
     * @return MessageInterface
     */
    public function createMessage($type,MapperInterface $mapper = null)
    {
        if(is_null($mapper)){
            $mapper = $this->getMapper();
        }

        $type = (new UnderscoreToCamelCase())->filter($type);
        return $mapper->getObject($type . 'Message');
    }

    /**
     *
     * @return ConversationInterface
     */
    public function createConversation($type,MapperInterface $mapper = null)
    {

        if(is_null($mapper)){
            $mapper = $this->getMapper();
        }
        $type = (new UnderscoreToCamelCase())->filter($type);
        return $mapper->getObject($type . 'Conversation');

    }



    /**
     * @param MessageInterface $message
     */
    public function saveMessage(MessageInterface $message, ConversationSubjectInterface $subject = null){

        if(!$message->getConversation() instanceof ConversationInterface){

            $conversationClass = $this->getOptions()->getConversationClass();

            $conversation = $this->getMapper()->getObject($conversationClass);

            if(!$conversation instanceof ConversationInterface){
                //TODO create custom Exception
                throw new \Exception('Expected object implements ConversationInterface. ' . get_class($conversation));
            }

            $conversation->setStatus(ConversationInterface::ACTIVE);
            $conversation->setTitle($message->getSubject());

            if($subject instanceof ConversationSubjectInterface){
                $conversation->setParticipants($subject->getParticipants());
                $conversation->setSubject($subject);
            }

            $conversation->addMessage($message);

        }

        $this->getMapper()->save($message);

        $this->processMessage($message);

    }

    /**
     * @param ConversationInterface $conversation
     */
    public function saveConversation(ConversationInterface $conversation){

        $this->getMapper()->save($conversation);

    }
    public function processMessage(MessageInterface $message){

        $conversation = $message->getConversation();
        if(!$conversation instanceof ConversationInterface){
            //TODO create custom exception
            throw new \Exception('Cannot create deliveries as message not associated with a conversation.');
        }

        foreach ($conversation->getParticipants() as $participant){


            $this->createDeliveries($participant, $message);

        }

    }
    /**
     *
     * @param ParticipantInterface $participant
     * @param MessageInterface $message
     * @throws \Exception
     */
    public function createDeliveries(ParticipantInterface $participant, MessageInterface $message){

        $conversation = $message->getConversation();

        foreach ($conversation->getDeliveryMethods() as $deliveryMethod){

            $transport = $this->getTransport($deliveryMethod);

            $delivery =  $transport->createDelivery($participant, $message);

            if(!$delivery instanceof DeliveryInterface){
                continue;
            }

            $this->saveDelivery($delivery);
        }
    }


    /**
     *
     * @param string $deliveryMethod
     */
    public function getTransportOptions($deliveryMethod){

        if(key_exists($deliveryMethod, $this->getOptions()->getTransport())){
            return $this->getOptions()->getTransport()[$deliveryMethod];
        }

        return false;
    }

    /**
     *
     * @param string $deliveryMethod
     * @throws \Exception
     */
    public function getTransport($deliveryMethod){

        if($this->getServiceLocator()->has('bsconversation_transport_'.$deliveryMethod)){

            $transport = $this->getServiceLocator()->get('bsconversation_transport_'.$deliveryMethod);
            if($transport instanceof TransportInterface){
                return $transport;
            }
        }

        throw new \Exception('Invalid delivery method or transport service');


    }

    /**
     *
     * @param DeliveryInterface $delivery
     */
    public function saveDelivery(DeliveryInterface $delivery){
        $this->eventManager->trigger('ConversationService.saveDelivery', $this, [
                'delivery' => $delivery
        ]);
        $this->getMapper()->save($delivery);

    }

    /**
     *
     * @param string $conversationId
     * @return ConversationInterface
     */
    public function findConversation($conversationId){

        return $this->getMapper()->getRepository($this->getOptions()->getConversationClass())->find($conversationId);

    }

}