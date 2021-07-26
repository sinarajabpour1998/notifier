<?php

namespace Sinarajabpour1998\Notifier\Drivers;

use Sinarajabpour1998\Notifier\Traits\SMSTrait;
use Ghasedak\GhasedakApi;
use Sinarajabpour1998\Notifier\Abstracts\Driver;

class Ghasedak extends Driver
{
    use SMSTrait;

    public function send($userId, $templateId, $params = [],  $options = [])
    {
        $this->setVariables($userId,$templateId,$params,$options);
        $this->set_sms_template();
        switch ($this->options['method']){
            case 'otp';
                $message_result = $this->send_otp_sms();
                break;
            case 'simple':
                // send simple sms function
                break;
            default:
                throw new \ErrorException("sms 'method' not found.");
        }
        $this->save_sms_log($this->options['method'],$this->template, $this->user->mobile, $message_result->result->code);
        // return sms result
        return (object) [
            'status' => $message_result->result->code,
            'message' => $message_result->result->message
        ];
    }

    protected function send_otp_sms()
    {
        $this->setUser();
        if (!array_key_exists('ghasedak_template_name', $this->options)){
            throw new \ErrorException("you must have 'ghasedak_template_name' key in your options");
        }
        if (array_key_exists('param11', $this->params)){
            throw new \ErrorException("only 10 params accepted in params (remove param11 to solve this error)");
        }
        $api = new GhasedakApi($this->getInformation()['api_key'],$this->getInformation()['api_url']);
        (object) $result = $api->Verify(
            $this->user->mobile,
            1,
            $this->options['ghasedak_template_name'],
            $this->params['param1'] ?? '',
            $this->params['param2'] ?? '',
            $this->params['param3'] ?? '',
            $this->params['param4'] ?? '',
            $this->params['param5'] ?? '',
            $this->params['param6'] ?? '',
            $this->params['param7'] ?? '',
            $this->params['param8'] ?? '',
            $this->params['param9'] ?? '',
            $this->params['param10'] ?? ''
        );
        return $result;
    }


}
