<?php
namespace BsConversation\Model\Mapper\ODM\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use BsConversation\Model\ParticipantInterface;
use BsConversation\Model\MessageInterface;
use BsBase\Model\Mapper\ODM\Document\AbstractDocument;
use BsConversation\Model\DeliveryInterface;

/**
 *
 * @ODM\Document
 *        
 */
abstract class AbstractDelivery extends AbstractDocument implements DeliveryInterface
{

    /**
     * @ODM\Field(type="date")
     * @var \DateTime
     */
    protected $deliveredAt;

    
    protected $message;
    
    /**
     * @ODM\Field(type="string")
     * @var string
     */
    protected $status;
    
    /**
     * @ODM\Field(type="date")
     * @var \DateTime
     */
    protected $seenAt;
    
    /**
     * @ODM\Field(type="string")
     * @var string
     */
    protected $deliveryTransport;
    
    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\Delivery::setDeliveredAt()
     *
     */
    public function setDeliveredAt(\DateTime $deliveredAt)
    {
        $this->deliveredAt = $deliveredAt;
    }


    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\Delivery::getMessage()
     *
     */
    public function getMessage()
    {
        return $this->message;
    }


    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\Delivery::setMessage()
     *
     */
    public function setMessage(MessageInterface $message)
    {
        $this->message = $message;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\Delivery::getStatus()
     *
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\Delivery::setStatus()
     *
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\Delivery::getDeliveredAt()
     *
     */
    public function getDeliveredAt()
    {
        return $this->deliveredAt;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\Delivery::getSeenAt()
     *
     */
    public function getSeenAt()
    {
        return $this->seenAt;
    }

    /**
     * (non-PHPdoc)
     *
     * @see \BsConversation\Model\Delivery::setSeenAt()
     *
     */
    public function setSeenAt(\DateTime $seenAt)
    {
        $this->seenAt = $seenAt;
    }
    /**
     * @return the $deliveryType
     */
    public function getDeliveryTransport()
    {
        return $this->deliveryTransport;
    }

    /**
     * @param string $deliveryType
     */
    public function setDeliveryTransport($deliveryTransport)
    {
        $this->deliveryTransport = $deliveryTransport;
    }

}
