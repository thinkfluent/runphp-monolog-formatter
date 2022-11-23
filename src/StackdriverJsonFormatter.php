<?php

namespace ThinkFluent\RunPHP\Logging;

use Monolog\Handler\AbstractProcessingHandler;
use ThinkFluent\RunPHP\Runtime;

class StackdriverJsonFormatter extends \Monolog\Formatter\JsonFormatter
{

    /**
     * When running in Google Cloud, apply this JSON formatter to the provided log handler
     *
     * @param AbstractProcessingHandler $handler
     */
    public static function applyInGoogleCloudContext(AbstractProcessingHandler $handler)
    {
        if(Runtime::get()->isGoogleCloud()) {
            $handler->setFormatter(new self());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function format(array $record): string
    {
        return \json_encode(
            $this->formatRecord($record)
        ) . ($this->appendNewline ? PHP_EOL : '');
    }

    /**
     * {@inheritdoc}
     */
    protected function formatBatchJson(array $records): string
    {
        return \json_encode(
            \array_map(
                [$this, 'formatRecord'],
                $records
            )
        );
    }

    /**
     * Format a log record for Google Cloud logging. Augment as needed.
     *
     * @param array $record
     * @return array
     */
    protected function formatRecord(array $record): array
    {
        return \array_merge(
            $record['context'],
            $record['extra'],
            [
                'message' => $record['message'],
                'severity' => $record['level_name'],
                'timestamp' => [
                    'seconds' => $record['datetime']->getTimestamp(),
                    'nanos' => 0,
                ],
                'channel' => $record['channel'],
                'logging.googleapis.com/trace' => Runtime::get()->getTraceContext(),
            ]
        );
    }
}
