<?php
namespace ZDTSwitchBoard;

use Zend\ModuleManager\ModuleManagerInterface;
use Zend\ModuleManager\ModuleEvent;

class Module
{

    const CONFIG_KEY = 'zdt_switch_board_options';

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function init(ModuleManagerInterface $manager)
    {
        $eventManager = $manager->getEventManager();
        $eventManager->attach(
            'profiler_init',
            array($this, 'profilerInit')
        );
    }

    public function profilerInit($event)
    {
        $serviceManager = $event->getParam('ServiceManager');

        $collector = $serviceManager->get('ZDTSwitchBoard\Collector\SwitchBoardCollector');

        $collector->updateOptions($event);
    }

    public function getAutoloaderConfig()
    {
    }
}
