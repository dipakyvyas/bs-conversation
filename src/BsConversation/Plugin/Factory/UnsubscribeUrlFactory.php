<?php
namespace BsConversation\Plugin\Factory;

use Zend\ServiceManager\FactoryInterface;
use BsConversation\Plugin\UnsubscribeUrl;
use Zend\View\Helper\Url;

/**
 *
 * @author jonasgarbuio
 *        
 */
class UnsubscribeUrlFactory implements FactoryInterface
{
    
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator){
        
        return new UnsubscribeUrl($serviceLocator->get('ViewHelperManager')->get('url'));
    }
    
}