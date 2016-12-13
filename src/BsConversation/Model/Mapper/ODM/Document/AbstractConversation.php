<?php
namespace BsConversation\Model\Mapper\ODM\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use BsConversation\Model\ConversationInterface;
use BsBase\Model\Mapper\BsObjectInterface;
use BsConversation\Model\ParticipantInterface;
use Doctrine\Common\Collections\ArrayCollection;
use BsBase\Model\Mapper\ODM\Document\AbstractDocument;
use BsConversation\Model\MessageInterface;

/**
 * @ODM\Document
 *        
 */
abstract class AbstractConversation extends AbstractDocument implements ConversationInterface
{

    protected $subject;
    
    /**
     * @ODM\Field(type="string")
     * @var string
     */
    protected $title;
    
    protected $participants;
    
    /**
     * @ODM\Field(type="string")
     * @var boolean
     */
    protected $status;
    
    /**
     * @ODM\Field(type="collection")
     * @var array
     */
    protected $metadata;
    
    /**
     * @ODM\Field(type="date")
     * @var unknown
     */
    protected $lastMessageDate;

    /**
     * @ODM\Field(type="hash")
     * @var ArrayCollection
     */
    protected $deliveryMethods;
    
    
    public function __construct(){
        $this->participants = new ArrayCollection();
    }
    
    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\ConversationInterface::getSubject()
     *
     */
    public function getSubject()
    {
        return $this->subject;
    }


    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\ConversationInterface::setSubject()
     *
     */
    public function setSubject(BsObjectInterface $subject)
    {
        $this->subject = $subject;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\ConversationInterface::getMetadata()
     *
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\ConversationInterface::getParticipants()
     *
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\ConversationInterface::removeParticipant()
     *
     */
    public function removeParticipant(ParticipantInterface $participant)
    {
        $this->participants->removeElement($participant);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\ConversationInterface::getLastMessageDate()
     *
     */
    public function getLastMessageDate()
    {
        return $this->lastMessageDate;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\ConversationInterface::setTitle()
     *
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }


    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\ConversationInterface::getStatus()
     *
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\ConversationInterface::setStatus()
     *
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\ConversationInterface::setMetadata()
     *
     */
    public function setMetadata(array $metaData)
    {
        $this->metadata = $metadata;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\ConversationInterface::getTitle()
     *
     */
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\ConversationInterface::addParticipant()
     *
     */
    public function addParticipant(ParticipantInterface $participant)
    {
        $this->participants->add($participant);
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\ConversationInterface::setLastMessageDate()
     *
     */
    public function setLastMessageDate(\DateTime $lastMessageDate)
    {
        $this->lastMessageDate = $lastMessageDate;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\ConversationInterface::setParticipants()
     *
     */
    public function setParticipants(ArrayCollection $participants)
    {
        $this->participants = $participants;
    }

    public function addMessage(MessageInterface $message){
        $message->setConversation($this);
    }
    /**
     * @return the $deliveryMethods
     */
    public function getDeliveryMethods()
    {
        return $this->deliveryMethods;
    }

    /**
     * @param multitype: $deliveryMethods
     */
    public function setDeliveryMethods($deliveryMethods)
    {
        $this->deliveryMethods = $deliveryMethods;
    }
    /**
     * 
     * {@inheritDoc}
     * @see \BsConversation\Model\ConversationInterface::addDeliveryMethod()
     */
    public function addDeliveryMethod($deliveryMethod){
        $this->deliveryMethods[] = $deliveryMethod;
    }
    /**
     * 
     * @param string $deliveryMethod
     */
    public function removeDeliveryMethod($deliveryMethod){
        $key = array_search($deliveryMethod, $this->deliveryMethods);
        unset($this->deliveryMethods[$key]);
    }
    
}