<?php

namespace ZDTSwitchBoard\Options;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use ZDTSwitchBoard\Module;

class SwitchBoardOptionsFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('config');

        if (isset($config[Module::CONFIG_KEY])) {
            return new SwitchBoardOptions($config[Module::CONFIG_KEY]);
        }

        return new SwitchBoardOptions();
    }
}

