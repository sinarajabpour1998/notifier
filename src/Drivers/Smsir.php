<?php

namespace Sinarajabpour1998\Notifier\Drivers;

use Sinarajabpour1998\Notifier\Traits\SMSTrait;
use Sinarajabpour1998\Notifier\Abstracts\Driver;
use GuzzleHttp\Client;

class Smsir extends Driver
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
        $this->save_sms_log($this->options['method'],$this->template, $this->user->mobile, $message_result['IsSuccessful']);
        // return sms result
        return (object) [
            'status' => $message_result['IsSuccessful'],
            'message' => $message_result['Message']
        ];
    }

    protected function send_otp_sms()
    {
        $this->setUser();
        if (array_key_exists('param2', $this->params)){
            throw new \ErrorException("only 1 param accepted in params (remove param2 to solve this error)");
        }
        $client = new Client();
        $body   = ['Code'=>$this->params['param1'],'MobileNumber'=>$this->user->mobile];
        $result = $client->post($this->getInformation()['api_url'].'api/VerificationCode',['json'=>$body,'headers'=>['x-sms-ir-secure-token'=>$this->getToken()],'connect_timeout'=>30]);
        return json_decode($result->getBody(),true);
    }

    protected function getToken()
    {
        $client     = new Client();
        $body       = ['UserApiKey'=>$this->getInformation()['api_key'],'SecretKey'=>$this->getInformation()['secret_key'],'System'=>'laravel_v_1_4'];
        $result     = $client->post($this->getInformation()['api_url'].'api/Token',['json'=>$body,'connect_timeout'=>30]);
        return json_decode($result->getBody(),true)['TokenKey'];
    }

}
