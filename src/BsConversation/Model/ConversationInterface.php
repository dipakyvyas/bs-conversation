<?php
namespace BsConversation\Model;

use BsBase\Model\Mapper\BsObjectInterface;
use Doctrine\Common\Collections\ArrayCollection;

interface ConversationInterface extends BsObjectInterface
{
    
    const ARCHIVED = 'archived';
    const ACTIVE = 'active';
    
    /**
     * @return BsObjectInterface $subject
     */
    public function getSubject();
    
    /**
     * 
     * @param BsObjectInterface $subject
     */
    public function setSubject(BsObjectInterface $subject);
    
    /**
     * @return string $title
     */
    public  function getTitle();
    /**
     * 
     * @param string $title
     */
    public function setTitle($title);
    
    /**
     * @return string $status
     */
    public function getStatus();
    
    /**
     * 
     * @param string $status
     */
    public function setStatus($status);
    
    /**
     * @return ParticipantInterface $participant
     */
    public function getParticipants();
    /**
     * 
     * @param ArrayCollection $participants
     */
    public function setParticipants(ArrayCollection $participants);
    /**
     * 
     * @param ParticipantInterface $participant
     */
    public function addParticipant(ParticipantInterface $participant);
    /**
     * 
     * @param ParticipantInterface $participant
     */
    public function removeParticipant(ParticipantInterface $participant);
    
    /**
     * @return \DateTime $lastMessageDate
     */
    public function getLastMessageDate();
    /**
     * 
     * @param \DateTime $lastMessageDate
     */
    public function setLastMessageDate(\DateTime $lastMessageDate);
    
    /**
     * @return array $metadata
     */
    public function getMetadata();
    /**
     * 
     * @param array $metaData
     */
    public function setMetadata(array $metaData);

    /**
     * 
     * @param MessageInterface $message
     */
    public function addMessage(MessageInterface $message);
 
    /**
     * @return array $deliveryMethods
     */
    public function getDeliveryMethods();
    /**
     * @param string $deliveryMethod
     */
    public function addDeliveryMethod($deliveryMethod);
    /**
     * 
     * @param string $deliveryMethod
     */
    public function removeDeliveryMethod($deliveryMethod);
}