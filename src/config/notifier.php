<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Driver
    |--------------------------------------------------------------------------
    |
    | This value determines which of the following sms service to use.
    | You can switch to a different driver at runtime.
    | Available Drivers : auto (Switch on failure) , ghasedak
    |
    */
    'default' => 'ghasedak',

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
                'api_key' => '',
                'api_url' => 'http://api.ghasedak.me/v2/',
                'line_number' => ''
            ],
            'options' => [

            ]
        ],
        'smart_sms' => [
            'constructor' => [
                'line_number' => '',
                'user_id' => '',
                'password'   => '',
                'default_sms_rcpt'   => '',
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
        'ghasedak' => \Sinarajabpour1998\Notifier\Drivers\Ghasedak::class
    ]
];
