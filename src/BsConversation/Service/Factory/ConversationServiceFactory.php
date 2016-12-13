<?php
namespace BsConversation\Service\Factory;

use Zend\ServiceManager\FactoryInterface;
use BsConversation\Service\ConversationService;
/**
 *
 * @author jonasgarbuio
 *        
 */
class ConversationServiceFactory implements FactoryInterface
{
    
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
         

        return new ConversationService($serviceLocator->get('bsconversation_options'), $serviceLocator->get('bsconversation_mapper'),$serviceLocator->get('bsconversation_events'));
    }
    
}