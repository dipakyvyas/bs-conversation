<?php
namespace BsConversation\Model\Mapper\ODM\Document;

/**
 *
 * @author jonasgarbuio
 *        
 */
trait SMTPDeliveryInterfaceTrait {
    

    /**
     * @ODM\Field(type="string")
     * @var string
     */
    protected $email;
    
    /**
     * @ODM\Field(type="string")
     * @var string
     */
    protected $from;
    
    /**
     * @ODM\Field(type="string")
     * @var string
     */
    protected $replyTo;
    
    /**
     * @return the $email
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    /**
     * {@inheritDoc}
     * @see \BsConversation\Model\DeliverySMTPInterface::getFrom()
     */
    public function getFrom()
    {
        return $this->from;
    }
    
    /**
     * {@inheritDoc}
     * @see \BsConversation\Model\DeliverySMTPInterface::getReplyTo()
     */
    public function getReplyTo()
    {
        return $this->replyTo;
    }
    
    /**
     * {@inheritDoc}
     * @see \BsConversation\Model\DeliverySMTPInterface::setFrom($from)
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }
    
    /**
     * {@inheritDoc}
     * @see \BsConversation\Model\DeliverySMTPInterface::setReplyTo($replyTo)
     */
    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;
    }
    
    
}