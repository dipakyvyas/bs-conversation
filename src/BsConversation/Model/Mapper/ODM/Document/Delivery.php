<?php
namespace BsConversation\Model\Mapper\ODM\Document;

use BsConversation\Model\Mapper\ODM\Document\AbstractDelivery;
use BsConversation\Model\DeliveryInterface;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document
 * @ODM\InheritanceType("SINGLE_COLLECTION")
 * @ODM\DiscriminatorField("type")
 * @ODM\DiscriminatorMap({"smtp"="SMTPDelivery"})
 */
class Delivery extends AbstractDelivery implements DeliveryInterface
{


}