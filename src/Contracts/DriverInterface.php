<?php

namespace Sinarajabpour1998\Notifier\Contracts;

interface DriverInterface
{
    public function send($userId, $templateId, $params = [],  $options = []);
}
