<?php

namespace Sinarajabpour1998\Notifier\Abstracts;

use Sinarajabpour1998\Notifier\Contracts\DriverInterface;

abstract class Driver implements DriverInterface
{

    public $driver;

    public function __construct($driver)
    {
        $this->driver = $driver;
    }

    abstract public function send($userId, $templateId, $params = [],  $options = [], $template_params = [], $sms_ir_templateId = null);

    public function getInformation() {
        return config('notifier.information')[$this->driver]['constructor'];
    }

    public function getUserModel()
    {
        $class = config('notifier.user_model');
        return new $class;
    }
}
