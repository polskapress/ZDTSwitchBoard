<?php

namespace ZDTSwitchBoard\Collector;

use ZendDeveloperTools\Collector\CollectorInterface;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

use ZendDeveloperTools\Collector\AbstractCollector;

use ZDTSwitchBoard\Module;

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
        $application = $mvcEvent->getApplication();
        if (!$application) {
            return;
        }

        $serviceLocator = $application->getServiceManager();

        if ($serviceLocator->has('Config')) {
            $this->data = $serviceLocator->get('config');
            $this->data = $this->data[Module::CONFIG_KEY];
        }

        $request = $mvcEvent->getRequest();
        $cookies = $request->getCookie();

        if (!isset($cookies[$this->cookieKey])) {
            return;
        }

        $data = json_decode($cookies[$this->cookieKey], true);

        $switches = $this->data['switches'];

        $this->data['switches'] = array_replace_recursive($switches, array_intersect_key($data, $switches));

        $options = $serviceLocator->get('ZDTSwitchBoard\SwitchBoardOptions');
        $options->setFromArray($this->data);
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

