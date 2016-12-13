<?php
namespace BsConversation\Model\Mapper\ODM\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use BsConversation\Model\Mapper\ODM\Mapper;

class MapperFactory implements FactoryInterface
{

    /**
     *
     * {@inheritDoc}
     *
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Mapper($serviceLocator->get('odm'));
    }
}