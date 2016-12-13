<?php
namespace BsConversation\Model\Mapper\ODM\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use BsConversation\Model\MessageInterface;
use BsConversation\Model\ParticipantInterface;
use BsConversation\Model\ConversationInterface;
use BsBase\Model\Mapper\ODM\Document\AbstractDocument;

/**
 * @ODM\Document
 * @author jonasgarbuio
 *        
 */
abstract class AbstractMessage extends AbstractDocument implements MessageInterface
{
    
    /**
     * @ODM\Field(type="string")
     * @var string
     */
    protected $subject;
    
    /**
     * @ODM\Field(type="string")
     * @var string
     */
    protected $body;
    
    
    protected $conversation;
    
    /**
     * 
     * @var unknown
     */
    protected $createdBy;

    /**
     * send the message to the sender
     * @ODM\Field(type="bool")
     * @var bool
     */
    protected $sendCopy;
    
    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\MessageInterface::getSubject()
     *
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\MessageInterface::setSubject()
     *
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\MessageInterface::getBody()
     *
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\MessageInterface::getConversation()
     *
     */
    public function getConversation()
    {
        return $this->conversation;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\MessageInterface::setBody()
     *
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\MessageInterface::setCreatedBy()
     *
     */
    public function setCreatedBy(ParticipantInterface $participant)
    {
        $this->createdBy = $participant;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\MessageInterface::setConversation()
     *
     */
    public function setConversation(ConversationInterface $conversation)
    {
        $this->conversation = $conversation;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\MessageInterface::getCreatedBy()
     *
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
    
    public function __construct(){
        
    }
    /**
     * 
     * {@inheritDoc}
     * @see \BsConversation\Model\MessageInterface::getSendCopy()
     */
    public function getSendCopy()
    {
        return $this->sendCopy;
    }

    /**
     * 
     * {@inheritDoc}
     * @see \BsConversation\Model\MessageInterface::setSendCopy()
     */
    public function setSendCopy($sendCopy)
    {
        $this->sendCopy = $sendCopy;
    }

}