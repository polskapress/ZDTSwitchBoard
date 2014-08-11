<?php
namespace ZDTSwitchBoard;

use Zend\Stdlib\AbstractOptions;

class SwitchBoardOptions extends AbstractOptions
{
    public function setSwitches(array $switches)
    {
        $this->switches = $switches;
        return $this;
    }

    public function setSwitch($name, $value)
    {
        $this->switches[$name] = $value;
        return $this;
    }

    public function setCookieKey($string)
    {
        $this->cookieKey = $string;
        return $this;
    }

    public function getSwitch($name)
    {
        if (isset($this->switches[$name])) {
            return $this->switches[$name];
        }
        throw new \InvalidArgumentException('Undefined switch value was requested: ' . (string)$name);
    }
}

