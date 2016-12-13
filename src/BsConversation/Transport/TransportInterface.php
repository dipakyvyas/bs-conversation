<?php
namespace BsConversation\Transport;

use BsConversation\Model\DeliveryInterface;
use BsConversation\Model\ParticipantInterface;
use BsConversation\Model\MessageInterface;
/**
 *
 * @author jonasgarbuio
 *        
 */
interface TransportInterface
{
    /**
     * 
     * @param DeliveryInterface $delivery
     */   
    public function send(DeliveryInterface $delivery);
    /**
     * 
     * @param ParticipantInterface $participant
     * @param MessageInterface $message
     */
    public function createDelivery(ParticipantInterface $participant, MessageInterface $message);
}