<?php
namespace BsConversation\Transport\Factory;

use Zend\ServiceManager\FactoryInterface;
use BsConversation\Transport\SMTPTransport;
/**
 *
 * @author jonasgarbuio
 *        
 */
class SMTPTransportFactory implements FactoryInterface
{
    
    /**
     * {@inheritDoc}
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        return new SMTPTransport($serviceLocator->get('bsconversation_service'),$serviceLocator->get('bsconversation_plugin_unsubscribe_url'));
    }

    
    
    
}