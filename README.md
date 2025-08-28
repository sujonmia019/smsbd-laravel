# Laravel Multi-Provider SMS Package

A **flexible Laravel SMS package** that supports multiple SMS gateways like **BulkSMSBD**, **Twilio**, **Arena**, and **Elitbuzz**.  
It allows sending SMS using a **default sender** or a **custom sender** dynamically per message.

---

## Features

- **Multiple SMS Gateway Support**  
  Supports bangladeshi and internatonal gateways like **BulkSMSBD**, **Arena**, **Elitbuzz**, and **Twilio**.

- **Dynamic Sender ID**  
  Call `sender()` to set a custom sender per message, overriding the default config.

- **Default Sender Support**  
  If `sender()` is not called, the package automatically uses the `sender_id` from the config file.

- **Automatic Fallback**  
  If no sender is specified in `sender()` or config, the SMS is sent without a sender (where supported).

- **Facade for Clean Syntax**  
  Use `SMS::send()` or `SMS::sender()->send()` anywhere in your Laravel app.

- **Extensible Architecture**  
  Add new gateways easily by implementing `GatewayInterface` and updating `SMSService`.

- **Consistent API Responses**  
  Returns standardized array responses with success or error details.

- **Laravel Config Integration**  
  All gateway credentials, URLs, and sender IDs are configurable via `config/laravel-sms.php`.

- **Composer Installable**  
  Package can be installed via Composer and integrated seamlessly with Laravel.


## Installation

Require the package via Composer:

```bash
composer require sujonmia/laravel-sms
```

## Configuration

### 1. Register Service Provider & Facade Alias

Open `config/app.php` and add the provider & alias:

```php
'providers' => [
    // Other Service Providers...
    SujonMia\Smsbd\SMSServiceProvider::class,
],

'aliases' => [
    // Other Facades...
    'SMS' => \SujonMia\Smsbd\Facades\SMS::class,
],
```

### 2. Example Usage in Controller

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SujonMia\Smsbd\Facades\SMS;

class SmsController extends Controller
{
    public function send()
    {
        // Send with default sender (from config)
        SMS::send('017XXXXXXXX', 'Hello from default sender!');

        // Send with custom sender
        SMS::sender('SUJON')->send('017XXXXXXXX', 'Hello from custom sender!');
    }
}
```

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

---

## Credits

- [Sujon](https://github.com/sujonmia019) – Author & Maintainer  
- [Laravel](https://laravel.com) – Framework used  

---

## Contributing

Contributions are welcome!  
If you’d like to improve this package, please fork the repo and submit a pull request.  

---
