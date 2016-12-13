<?php
namespace BsConversation\Model;

/**
 *
 * @author jonasgarbuio
 *        
 */
interface DeliverySMTPInterface extends DeliveryInterface
{
    /**
     * 
     */
    public function getEmail();
    /**
     * 
     * @param string $email
     */
    public function setEmail($email);
    
    /**
     * 
     */
    public function getReplyTo();
    /**
     * 
     * @param string $replyTo
     */
    public function setReplyTo($replyTo);
    
    /**
     * 
     */
    public function getFrom();
    /**
     * 
     * @param string $from
     */
    public function setFrom($from);
}