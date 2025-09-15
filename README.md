# Monolog JSON Formatter for Google Cloud Run

Designed to work with RunPHP Serverless Toolkit.

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
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;
use \ThinkFluent\RunPHP\Logging\StackdriverJsonFormatter;

$handler = new StreamHandler('php://stderr', Logger::INFO);
StackdriverJsonFormatter::applyInGoogleCloudContext($handler);
$logger = new Logger('my-log');
$logger->pushHandler($handler);
```