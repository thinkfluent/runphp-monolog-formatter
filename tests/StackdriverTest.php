<?php

use Monolog\Level;
use PHPUnit\Framework\TestCase;
use ThinkFluent\RunPHP\Logging\StackdriverJsonFormatter;

class StackdriverTest extends TestCase
{
    public function testStackdriver()
    {
        $formatter = new StackdriverJsonFormatter(\Monolog\Formatter\JsonFormatter::BATCH_MODE_JSON, true);
        //     public function __construct(
        //        public readonly \DateTimeImmutable $datetime,
        //        public readonly string $channel,
        //        public readonly Level $level,
        //        public readonly string $message,
        //        /** @var array<mixed> */
        //        public readonly array $context = [],
        //        /** @var array<mixed> */
        //        public array $extra = [],
        //        public mixed $formatted = null,
        //    ) {
        //    }
        $record = new \Monolog\LogRecord(
            new \DateTimeImmutable('2024-01-01 01:02:03'),
            'channel1',
            Level::Warning,
            'hi',
            ['key1' => 'value1'],
            ['key2' => 'value2']
        );
        $messageString = $formatter->format($record);

        $this->assertIsString($messageString);
        $this->assertEquals(PHP_EOL, substr($messageString, -1));
        $this->assertJson($messageString);

        $formatted = \json_decode($messageString, false);
        $this->assertIsObject($formatted);

        $this->assertObjectHasProperty('key1', $formatted);
        $this->assertEquals('value1', $formatted->key1);
        $this->assertObjectHasProperty('key2', $formatted);
        $this->assertEquals('value2', $formatted->key2);
        $this->assertObjectHasProperty('message', $formatted);
        $this->assertEquals('hi', $formatted->message);
        $this->assertObjectHasProperty('severity', $formatted);
        $this->assertEquals('WARNING', $formatted->severity);
        $this->assertObjectHasProperty('timestamp', $formatted);
        $this->assertObjectHasProperty('seconds', $formatted->timestamp);
        $this->assertEquals(1704070923, $formatted->timestamp->seconds);
        $this->assertObjectHasProperty('channel', $formatted);
        $this->assertEquals('channel1', $formatted->channel);
        $this->assertObjectHasProperty('logging.googleapis.com/trace', $formatted);
        $this->assertIsString($formatted->{'logging.googleapis.com/trace'});
    }
}