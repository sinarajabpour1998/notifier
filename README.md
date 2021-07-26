# Laravel Notifier Package For Iranian SMS Services
[![GitHub issues](https://img.shields.io/github/issues/sinarajabpour1998/notifier?style=flat-square)](https://github.com/sinarajabpour1998/notifier/issues)
[![GitHub stars](https://img.shields.io/github/stars/sinarajabpour1998/notifier?style=flat-square)](https://github.com/sinarajabpour1998/notifier/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/sinarajabpour1998/notifier?style=flat-square)](https://github.com/sinarajabpour1998/notifier/network)
[![GitHub license](https://img.shields.io/github/license/sinarajabpour1998/notifier?style=flat-square)](https://github.com/sinarajabpour1998/notifier/blob/main/LICENSE)

This is a Laravel Package for SMS Service Integration.

#### List of available drivers

- [ghasedak](https://ghasedak.io/)
- [sms.ir](https://sms.ir/)

## How to install and config [sinarajabpour1998/notifier](https://github.com/sinarajabpour1998/notifier) package?

#### Installation

```

composer require sinarajabpour1998/notifier

```

#### Publish Config file

```

php artisan vendor:publish --tag=notifier

```

#### Migrate tables, to add notifier tables to database

```

php artisan migrate

```

#### How to use exists drivers from package

- Set the configs in /config/notifier.php

- Use this sample code to send sms

    ```
      Notifier::driver('{driver_name}(like ghasedak)')
            ->userId(user_id_integer)
            ->templateId({template_id_integer(must be defined in a seeder)})
            ->params(['param1' => 'string', ... ,'param10' => 'string'])
            ->options(['method' => '{driver_method_name}(like otp)','hasPassword' => 'if_this_message_has_password(yes or no)'])
            ->send();
    ```
  
- Ghasedak OTP method example :

    ```php
      Notifier::driver('ghasedak')
            ->userId(2)
            ->templateId(1)
            ->params(['param1' => 'passwdsd12ds'])
            ->options(['method' => 'otp','ghasedak_template_name' => 'registration', 'hasPassword' => 'yes'])
            ->send();
    ```

## Parameters
| Parameter | Required | Description | Type | Example |  
| --- | --- | --- | --- | --- |  
| driver | No | Driver to be used | string | ghasedak |  
| userId |  No | The id of the receiver user. | integer | 12 |  
| templateId | Yes | The id of the template of the message, which, specified in your seeder.**```(You must create a seeder before continue, please read the seeder part)```** | integer | 14 |  
| params | Yes | All the parameters that you want to put in the sms template. | array | ['param1' => 'passwdsd12ds', 'param2' => 'my text'] |  
| options | Yes | It is used to set several options for each driver,a driver maybe contains it's own options. | array | ['method' => 'otp','ghasedak_template_name' => 'registration', 'hasPassword' => 'yes'] |


## Template Seeder
- Basic and standard structure :
```php
  public function run()
    {
        DB::table('notifier_sms_templates')->insertOrIgnore([
            [
                'id' => 1,
                'template_text' => 'جهت اطلاعات بیشتر به این وبسایت مراجعه کنید : [param1]',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
```
* id : used in templateId option
* template_text : add your parameters by number (up to 10) in your message text like [param1] or [param2]


#### Requirements:

- PHP v7.0 or above
- Laravel v7.0 or above
- ghasedak/php package [packagist link](https://packagist.org/packages/ghasedak/php)

