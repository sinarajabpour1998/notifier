<?php

namespace Sinarajabpour1998\Notifier\Drivers;

use Sinarajabpour1998\Notifier\Traits\SMSTrait;
use Sinarajabpour1998\Notifier\Abstracts\Driver;
use GuzzleHttp\Client;

class Smsir extends Driver
{
    use SMSTrait;

    public function send($userId, $templateId, $params = [],  $options = [], $template_params = [], $sms_ir_templateId = null)
    {
        $this->setVariables($userId,$templateId,$params,$options,$template_params, $sms_ir_templateId);
        $this->set_sms_template();
        switch ($this->options['method']){
            case 'otp';
                $message_result = $this->send_otp_sms();
                break;
            case 'service';
                $message_result = $this->send_service_sms();
                break;
            case 'message_notification';
                $message_result = $this->send_message_notification_sms();
                break;
            case 'transaction';
                $message_result = $this->send_transaction_sms();
                break;
            case 'with-param':
            case 'simple':
                $message_result = $this->send_simple_sms();
                break;
            case 'with-template':
                $message_result = $this->send_sms_with_template();
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
        if (array_key_exists('param3', $this->params)){
            throw new \ErrorException("only 2 params accepted in params (remove param3 to solve this error)");
        }
        $SendDateTime = date("Y-m-d")."T".date("H:i:s");
        $client = new Client();
        $body   = [
            'ParameterArray' => [
                [
                    "Parameter" => "name",
                    "ParameterValue" => $this->params["param2"]
                ],
                [
                    "Parameter" => "code",
                    "ParameterValue" => $this->params["param1"]
                ]
            ],
            "Mobile" => $this->user->mobile,
            "TemplateId" => "5648"
        ];
        $result = $client->post("http://RestfulSms.com/api/UltraFastSend",['json'=>$body,'headers'=>['x-sms-ir-secure-token'=>$this->getToken()],'connect_timeout'=>30]);
        return json_decode($result->getBody(),true);
    }

    protected function send_service_sms()
    {
        $this->setUser();
        if (array_key_exists('param5', $this->params)){
            throw new \ErrorException("only 4 params accepted in params (remove param3 to solve this error)");
        }
        $client = new Client();
        $body   = [
            'ParameterArray' => [
                [
                    "Parameter" => "service",
                    "ParameterValue" => $this->params["param1"]
                ],
                [
                    "Parameter" => "date",
                    "ParameterValue" => $this->params["param2"]
                ],
                [
                    "Parameter" => "name",
                    "ParameterValue" => $this->params["param3"]
                ],
                [
                    "Parameter" => "mobile",
                    "ParameterValue" => $this->params["param4"]
                ]
            ],
            "Mobile" => $this->user->mobile,
            "TemplateId" => "4239"
        ];
        $result = $client->post("http://RestfulSms.com/api/UltraFastSend",['json'=>$body,'headers'=>['x-sms-ir-secure-token'=>$this->getToken()],'connect_timeout'=>30]);

        return json_decode($result->getBody(),true);
    }

    protected function send_message_notification_sms()
    {
        $this->setUser();
        if (array_key_exists('param3', $this->params)){
            throw new \ErrorException("only 2 params accepted in params (remove param3 to solve this error)");
        }
        $client = new Client();
        $body   = [
            'ParameterArray' => [
                [
                    "Parameter" => "name",
                    "ParameterValue" => $this->params["param1"]
                ],
                [
                    "Parameter" => "time",
                    "ParameterValue" => $this->params["param2"]
                ]
            ],
            "Mobile" => $this->user->mobile,
            "TemplateId" => "68421"
        ];
        $result = $client->post("http://RestfulSms.com/api/UltraFastSend",['json'=>$body,'headers'=>['x-sms-ir-secure-token'=>$this->getToken()],'connect_timeout'=>30]);

        return json_decode($result->getBody(),true);
    }

    protected function send_transaction_sms()
    {
        $this->setUser();
        if (array_key_exists('param2', $this->params)){
            throw new \ErrorException("only 1 param accepted in params (remove param2 to solve this error)");
        }
        $client = new Client();
        $body   = [
            'ParameterArray' => [
                [
                    "Parameter" => "amount",
                    "ParameterValue" => $this->params["param1"]
                ]
            ],
            "Mobile" => $this->user->mobile,
            "TemplateId" => "68744"
        ];
        $result = $client->post("http://RestfulSms.com/api/UltraFastSend",['json'=>$body,'headers'=>['x-sms-ir-secure-token'=>$this->getToken()],'connect_timeout'=>30]);

        return json_decode($result->getBody(),true);
    }

    protected function send_simple_sms()
    {
        $result = $this->send_sms();
        return json_decode($result->getBody(),true);
    }

    protected function send_sms()
    {
        $this->setUser();
        $SendDateTime = date("Y-m-d")."T".date("H:i:s");
        $client = new Client();
        $body   = ['Messages'=>array($this->original_template),'MobileNumbers'=>array($this->user->mobile),'LineNumber'=>$this->getInformation()['line_number'],'SendDateTime'=>$SendDateTime];
        $result = $client->post($this->getInformation()['api_url'].'api/MessageSend',['json'=>$body,'headers'=>['x-sms-ir-secure-token'=>$this->getToken()],'connect_timeout'=>30]);
        return $result;
    }

    protected function getToken()
    {
        $client     = new Client();
        $body       = ['UserApiKey'=>$this->getInformation()['api_key'],'SecretKey'=>$this->getInformation()['secret_key'],'System'=>'laravel_v_1_4'];
        $result     = $client->post($this->getInformation()['api_url'].'api/Token',['json'=>$body,'connect_timeout'=>30]);
        return json_decode($result->getBody(),true)['TokenKey'];
    }

    protected function send_sms_with_template()
    {
        $this->setUser();
        $client = new Client();
        $body = [
            'ParameterArray' => $this->template_params,
            "Mobile" => $this->user->mobile,
            "TemplateId" => $this->sms_ir_templateId
        ];
        $result = $client->post("http://RestfulSms.com/api/UltraFastSend", ['json' => $body, 'headers' => ['x-sms-ir-secure-token' => $this->getToken()], 'connect_timeout' => 30]);
        return json_decode($result->getBody(), true);
    }

}
