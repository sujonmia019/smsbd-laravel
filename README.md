# Laravel Multi-Provider SMS Package

A **flexible Laravel SMS package** that supports multiple SMS gateways like **BulkSMSBD**, **Twilio**, **Arena**, and **Elitbuzz**.  
It allows sending SMS using a **default sender** or a **custom sender** dynamically per message.

---

## Features

- **Multiple SMS Gateway Support**  
  Supports bangladeshi and internatonal gateways like **BulkSMSBD**, **Arena**, **Elitbuzz**, and **Twilio**.

- **Centralized Configuration**
  Manage provider credentials from .env
  Switch default provider with SMS_GATEWAY

- **Auto Logging**
  All SMS requests stored in sms_logs table

- **Event Driven**
  `SmsSent` event fired after successful send
  `SmsFailed` event fired if provider fails

- **Dynamic Sender ID**  
  Call `sender()` to set a custom sender per message, overriding the default config.

- **Default Sender Support**  
  If `sender()` is not called, the package automatically uses the `sender_id` from the config file.

- **Facade for Clean Syntax**  
  Use `SMS::send()` or `SMS::sender()->send()` anywhere in your Laravel app.

- **Extensible Architecture**  
  Add new gateways easily by implementing `GatewayInterface` and updating `SMSService`.

- **Consistent API Responses**  
  Returns standardized array responses with success or error details.

- **Laravel Config Integration**  
  All gateway credentials, URLs, and sender IDs are configurable via `config/laravel-sms.php`.

- **Error Handling**
  Exceptions thrown on missing credentials or failed response

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

### 2. Publish Config & Migration

```php
php artisan vendor:publish --provider="SujonMia\Smsbd\SMSServiceProvider"
php artisan migrate
```

### 3. Add Environment Variables
```php
# Default provider
SMS_GATEWAY=arena

# Arena SMS
ARENA_API_KEY=your_api_key
ARENA_ACODE=your_acode
ARENA_SENDER_ID=MYSHOP
ARENA_URL=https://sms.lpeek.com/API/sendSMS

# Elitbuzz
ELITBUZZ_API_KEY=your_api_key
ELITBUZZ_TYPE=text
ELITBUZZ_SENDER_ID=MYSHOP
ELITBUZZ_URL=https://msg.elitbuzz-bd.com/smsapi

# BulkSMSBD
BULKSMSBD_API_KEY=your_api_key
BULKSMSBD_SENDER_ID=MYSHOP
BULKSMSBD_URL=http://bulksmsbd.net/api/smsapi

# Twilio
TWILIO_SID=your_sid
TWILIO_TOKEN=your_token
TWILIO_SENDER_ID=+123456789
```

### 4. Example Usage in Controller

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

        // Explicit provider
        SMS::via('arena')->send('8801743776488','Hello via Arena');

        // Another provider
        SMS::via('bulksmsbd')->send('01743776488','Hello via BulkSMSBD');

        // Another provider with custom sender
        SMS::via('bulksmsbd')->sender('SUJON')->send('01743776488','Hello via from custom sender BulkSMSBD');
    }
}
```

### 5. Log & View History

```php
use SujonMia\Smsbd\Models\SmsLog;

$logs = SmsLog::where('status', 'sent')->latest()->get();
```

### 6. Example SMS Logs Table

| ID | To          | Message             | Provider                                | Status | Response       | Created At |
|----|-------------|---------------------|-----------------------------------------|--------|----------------|------------|
| 1  | 017XXXXXXXX | Your OTP is 123456  | SujonMia\Smsbd\Gateways\TwilioGatewa    | sent   | {…} JSON Data  | 2025-08-30 |
| 2  | 018XXXXXXXX | Promo: 50% OFF      | SujonMia\Smsbd\Gateways\ArenaGatewa     | failed | Error Message  | 2025-08-30 |
| 3  | 016XXXXXXXX | Your appointment..  | SujonMia\Smsbd\Gateways\ElitbuzzGatewa  | sent   | Error Message  | 2025-08-30 |
| 3  | 015XXXXXXXX | Thank you..         | SujonMia\Smsbd\Gateways\BulkSMSBDGatewa | sent   | Error Message  | 2025-08-30 |


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

