<?php
namespace BsConversation\Model;


use BsBase\Model\Mapper\BsObjectInterface;
interface MessageInterface extends BsObjectInterface
{
    
    /**
     * @return string $subject
     */
    public function getSubject();
    /**
     * 
     * @param unknown $subject
     */
    public function setSubject($subject);
    
    /**
     * @return string $body
     */
    public function getBody();
    /**
     * 
     * @param unknown $body
     */
    public function setBody($body);
    
    /**
     * @return ConversationInterface $conversation
     */
    public function getConversation();
    /**
     * 
     * @param ConversationInterface $conversation
     */
    public function setConversation(ConversationInterface $conversation);
    
    /**
     * @return ParticipantInterface $createdBy
     */
    public function getCreatedBy();
    /**
     * 
     * @param ParticipantInterface $participant
     */
    public function setCreatedBy(ParticipantInterface $participant);
    
    /**
     * @return bool $sendCopy
     */
    public function getSendCopy();
    
    /**
     * @param bool $sendCopy
     */
    public function setSendCopy($sendCopy);
    
    
}