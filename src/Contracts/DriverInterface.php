<?php

namespace Sinarajabpour1998\Notifier\Contracts;

interface DriverInterface
{
    public function send($userId, $templateId, $params = [],  $options = [], $template_params = [], $sms_ir_templateId = null);
}
