<?php

namespace Sinarajabpour1998\Notifier\Core;

class SMSNotifier
{
    protected $driver;
    protected $userId;
    protected $templateId;
    protected $params;
    protected $options;
    protected $config;
    protected $template_params;
    protected $sms_ir_templateId;

    public function __construct()
    {
        $this->config = config('notifier');
    }

    public function send()
    {
        $object = $this->fireDriver();
        return $object->send($this->userId, $this->templateId, $this->params, $this->options, $this->template_params, $this->sms_ir_templateId);
    }

    public function getDriver()
    {
        (is_null($this->driver))
            ? $driver = $this->config['default']
            : $driver = $this->driver;
        return $driver;
    }

    public function fireDriver()
    {
        $class = $this->config['drivers'][$this->getDriver()];
        return new $class($this->getDriver());
    }

    // Has parameter
    public function driver($driver = null)
    {
        $this->driver = $driver;
        return $this;
    }

    public function userId($userId)
    {
        $this->userId = (int) $userId;
        return $this;
    }

    public function templateId($templateId)
    {
        $this->templateId = $templateId;
        return $this;
    }

    public function params($params = [])
    {
        $this->params = $params;
        return $this;
    }

    public function options($options = [])
    {
        $this->options = $options;
        return $this;
    }

    public function template_params($template_params = [])
    {
        $this->template_params = $template_params;
        return $this;
    }

    public function sms_ir_templateId($sms_ir_templateId = null)
    {
        $this->sms_ir_templateId = $sms_ir_templateId;
        return $this;
    }
}
