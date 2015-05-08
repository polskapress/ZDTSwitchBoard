<?php

namespace ZDTSwitchBoard\Collector;

use ZendDeveloperTools\Collector\CollectorInterface;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;
use ZendDeveloperTools\Collector\AbstractCollector;
use Zend\EventManager\EventManager;
use ZDTSwitchBoard\Module;
use Zend\Console\Request as ConsoleRequest;

class SwitchBoardCollector extends AbstractCollector
{

    protected $cookieKey = 'zdt_switch_board';

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'switch-board';
    }

    /**
     * {@inheritDoc}
     */
    public function getPriority()
    {
        return 10;
    }

    /**
     * @inheritdoc
     */
    public function collect(MvcEvent $mvcEvent)
    {
        return null;
    }

    public function updateOptions($event)
    {
        $serviceLocator = $event->getParam('ServiceManager');
        $request = $serviceLocator->get('Request');

        if ($serviceLocator->has('Config')) {
            $this->data = $serviceLocator->get('config');
            $this->data = $this->data[Module::CONFIG_KEY];
        }

        if ($request instanceof ConsoleRequest) {
            $cookies = array();
        } else {
            $cookies = $request->getCookie();
        }
        
        if (!isset($cookies[$this->cookieKey])) {
            return;
        }

        $data = json_decode($cookies[$this->cookieKey], true);

        $switches = $this->data['switches'];

        $this->data['switches'] = array_replace_recursive($switches, array_intersect_key($data, $switches));

        $options = $serviceLocator->get('ZDTSwitchBoard\Options\SwitchBoardOptions');
        $options->setFromArray($this->data);

        $eventManager = new EventManager(__CLASS__);
        $eventManager->trigger('updateOptions', null, array('options' => $options, 'serviceLocator' => $serviceLocator));
    }

    public function getCookieKey()
    {
        return $this->cookieKey;
    }

    public function getSwitches()
    {
        return empty($this->data['switches']) ? array() : $this->data['switches'];
    }

}

