<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Driver
    |--------------------------------------------------------------------------
    |
    | This value determines which of the following sms service to use.
    | You can switch to a different driver at runtime.
    | Available Drivers : auto (Switch on failure) , ghasedak, smsir
    |
    */
    'default' => 'smsir',

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | This value determines which of the models used for users.
    |
    | You can change this if your user model is in the different location
    |
    */
    'user_model' => \App\Models\User::class,

    /*
    |--------------------------------------------------------------------------
    | Drivers Information
    |--------------------------------------------------------------------------
    |
    | These are the list of drivers information to use in package.
    | You can change the information.
    |
    */
    'information' => [
        'ghasedak' => [
            'constructor' => [
                'api_key' => env('GHASEDAK-API-KEY','Your ghasedak.io api key'),
                'api_url' => env('GHASEDAK-API-URL','http://api.ghasedak.me/v2/'),
                'line_number' => env('GHASEDAK-LINE-NUMBER','Your ghasedak.io line number')
            ],
            'options' => [

            ]
        ],
        'smsir' => [
            'constructor' => [
                'api_key' => env('SMSIR-API-KEY','Your sms.ir api key'),
                'secret_key' =>  env('SMSIR-SECRET-KEY','Your sms.ir secret key'),
                'api_url' => env('SMSIR-API-URL','https://ws.sms.ir/'),
                'line_number' => env('SMSIR-LINE-NUMBER','Your sms.ir line number')
            ],
            'options' => [

            ]
        ],
        'smart_sms' => [
            'constructor' => [
                'line_number' => env('SMARTSMS-LINE-NUMBER'),
                'user_id' => env('SMARTSMS-USER-ID'),
                'password'   => env('SMARTSMS-PASSWORD'),
                'default_sms_rcpt'   => env('SMARTSMS-DEFAULT-RCPT'),
            ],
            'options' => [

            ]
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | List of Drivers
    |--------------------------------------------------------------------------
    |
    | These are the list of drivers to use for this package.
    | You can change the name.
    |
    */
    'drivers' => [
        'ghasedak' => \Sinarajabpour1998\Notifier\Drivers\Ghasedak::class,
        'smsir' => \Sinarajabpour1998\Notifier\Drivers\Smsir::class
    ]
];
