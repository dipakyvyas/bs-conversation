<?php
namespace BsConversation\Model;


use BsBase\Model\Mapper\BsObjectInterface;
interface DeliveryInterface extends BsObjectInterface
{
    
    const PENDING = 'pending';
    
    const FAILED = 'failed';
    
    const DELIVERED = 'delivered';
    
    /**
     * @return MessageInterface $message
     */
    public function getMessage();
    /**
     * 
     * @param MessageInterface $message
     */
    public function setMessage(MessageInterface $message);
    

    /**
     * @return \DateTime $seenAt
     */
    public function getSeenAt();
    /**
     * 
     * @param \DateTime $seenAt
     */
    public function setSeenAt(\DateTime $seenAt);
    
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
     * @return \DateTime $deliveredAt
     */
    public function getDeliveredAt();
    /**
     * 
     * @param \DateTime $deliveredAt
     */
    public function setDeliveredAt(\DateTime $deliveredAt);
    
    /**
     * @return string $deliveryTransport
     */
    public function getDeliveryTransport();
    /**
     * 
     * @param string $deliveryType
     */
    public function setDeliveryTransport($deliveryTransport);
}