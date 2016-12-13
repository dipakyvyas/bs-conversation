<?php
namespace BsConversation\Options\Factory;

use Zend\ServiceManager\FactoryInterface;
use BsConversation\Options\Options;

class OptionsFactory implements FactoryInterface
{

    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $options = $config['bsconversation'];
        $options = new Options($options);
        return $options;
    }
}