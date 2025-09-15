# Monolog JSON Formatter for Google Cloud Run

This produces correctly formatted JSON log messages that are automatically parsed by Google Cloud Logging.

Designed to work with RunPHP Serverless Toolkit, but can also run standalone.

## Advantages

Ensures the current "trace context" is applied to log entries - meaning **logs can be grouped by request** in the Google Cloud Logging console.

## Install with Composer

```bash
composer require thinkfluent/runphp-monolog-formatter
```

### Monolog Version Compatibility
Monolog has changes in v3.x that are not backwards compatible with v2.x.

- For Monolog 1 or 2, use version `^1.0` of this package.
- For Monolog 3, use version `^2.0` of this package.

## Example Usage

```php
use \Monolog\Level;
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;
use \ThinkFluent\RunPHP\Logging\StackdriverJsonFormatter;

$handler = new StreamHandler('php://stderr', Level::Info);
StackdriverJsonFormatter::applyInGoogleCloudContext($handler);
$logger = new Logger('my-log');
$logger->pushHandler($handler);
```

In this sample we use `applyInGoogleCloudContext()` to only apply the JSON formatter when running in Google Cloud.

Locally, this will log a more human-readable format.

*Please Note* the auto-detection of GCP relies on code in from https://github.com/thinkfluent/runphp. If you're using
this formatter outside of RunPHP images, you'll have to implement your own detection.
