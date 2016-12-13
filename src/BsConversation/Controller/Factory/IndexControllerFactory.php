<?php
namespace BsConversation\Controller\Factory;

use Zend\ServiceManager\FactoryInterface;
use BsConversation\Controller\IndexController;
/**
 *
 * @author jonasgarbuio
 *        
 */
class IndexControllerFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     * @see \Zend\ServiceManager\FactoryInterface::createService()
     */
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        return new IndexController($serviceLocator->getServiceLocator()->get('bsconversation_service'),$serviceLocator->getServiceLocator()->get('bsconversation_options')); 
    }

    
    
    
}