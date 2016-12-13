<?php
namespace BsConversation\Model\Mapper\ODM\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use BsConversation\Model\DeliverySMTPInterface;

/**
 * @ODM\Document
 * @author jonasgarbuio
 *        
 */
class SMTPDelivery extends Delivery implements DeliverySMTPInterface
{

    use SMTPDeliveryInterfaceTrait;
    
}