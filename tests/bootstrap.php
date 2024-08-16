<?php

namespace ThinkFluent\RunPHP;

require_once __DIR__ . '/../vendor/autoload.php';

if (!class_exists('\\ThinkFluent\\RunPHP\\Runtime')) {
    class Runtime {
        public static function get() {
            return new Runtime();
        }
        public function isGoogleCloud(): bool {
            return true;
        }
        public function getTraceContext(): string {
            return 'trace-context';
        }
    }
}
