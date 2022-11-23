# Monolog JSON Formatter for Google Cloud Run

Designed to work with RunPHP Serverless Toolkit.

## Advantages

Ensures the current "trace context" is applied to log entries - meaning **logs can be grouped by request** in the Google Cloud Logging console.

## Install with Composer

```bash
composer require thinkfluent/runphp-monolog-formatter
```

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