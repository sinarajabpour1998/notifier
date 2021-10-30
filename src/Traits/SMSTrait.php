<?php

namespace Sinarajabpour1998\Notifier\Traits;

use Sinarajabpour1998\Notifier\Facades\NotifierToolsFacade;
use Sinarajabpour1998\Notifier\Models\NotifierSmsLog;
use Sinarajabpour1998\Notifier\Models\NotifierSmsTemplate;

trait SMSTrait
{
    protected $userId, $templateId, $params, $options;
    protected $user, $template, $original_template;

    protected function setVariables($userId,$templateId,$params,$options)
    {
        $this->userId = $userId;
        if (is_null($templateId) || $templateId == 0){
            throw new \ErrorException("templateId can't be 0 or null");
        }
        $this->templateId = $templateId;
        if ($options['method'] != 'simple'){
            if (is_null($params)){
                throw new \ErrorException("params can't be null");
            }
            if (!is_array($params)){
                throw new \ErrorException("params must be array");
            }
            $this->params = $params;
        }
        if (is_null($options)){
            throw new \ErrorException("options can't be null");
        }
        if (!is_array($options)){
            throw new \ErrorException("options must be array");
        }
        $this->options = $options;
        if (is_null($userId) || $userId == 0){
            if (!array_key_exists('receiver', $this->options)){
                throw new \ErrorException("userId is empty so you must have at least 'receiver' key in your options that contains receiver mobile number");
            }
        }
        if (!array_key_exists('method', $this->options)){
            throw new \ErrorException("you must have 'method' key in your options");
        }
        if ($this->options['method'] != 'simple' && !array_key_exists('param1', $this->params)){
            throw new \ErrorException("you must have at least 'param1' key in your params");
        }
    }

    protected function setUser()
    {
        if (!is_null($this->userId) && $this->userId != 0){
            $this->user = $this->getUserModel()->findOrFail($this->userId);
            $this->user->mobile = NotifierToolsFacade::dataDecryption($this->user->mobile);
        }else{
            $this->user = (object) [];
            $this->user->mobile = NotifierToolsFacade::dataDecryption($this->options['receiver']);
        }
    }

    public function save_sms_log($method,$sms_text,$reciver,$status)
    {
        $reciver = NotifierToolsFacade::dataEncryption($reciver);
        NotifierSmsLog::query()->create([
            'sms_template_id' => $this->templateId,
            'user_id' => $this->userId,
            'driver' => $this->driver,
            'sms_text' => $sms_text,
            'receiver' => $reciver,
            'method' => $method,
            'status' => $status
        ]);
        return [
            'status' => 200
        ];
    }

    protected function set_sms_template()
    {
        $template = NotifierSmsTemplate::query()->where('id', '=', $this->templateId)->first();
        if (is_null($template) || empty($template)){
            throw new \ErrorException("the templateId ({$this->templateId}) not found ! did you define this template in a seeder ? did you try php artisan db:seed ?");
        }
        $template_text = $template->template_text;
        if ($this->options['method'] != 'simple'){
            $original_text = str_replace('[param1]', $this->params['param1'], $template_text);
            if (array_key_exists('hasPassword', $this->options) && $this->options['hasPassword'] == 'yes'){
                $template_text = str_replace('[param1]', '********', $template_text);

            }else{
                $template_text = str_replace('[param1]', $this->params['param1'], $template_text);
            }
            for ($param_num = 2; $param_num <= 10; $param_num ++){
                if (array_key_exists("param$param_num", $this->params)){
                    $template_text = str_replace("[param$param_num]", $this->params["param$param_num"], $template_text);
                }
            }
            $this->original_template = $original_text;
        }else{
            $this->original_template = $template_text;
        }
        $this->template = $template_text;
    }
}
