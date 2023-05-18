<?php

namespace Hopex\Simplog;

use DateTimeZone;
use Dotenv\Dotenv;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;

class SimpleLog extends MonologLogger
{
    /**
     * SimpleLog constructor.
     * @param string $name
     * @param array $handlers
     * @param array $processors
     * @param DateTimeZone|null $timezone
     */
    public function __construct(
        string $name,
        array $handlers = [],
        array $processors = [],
        ?DateTimeZone $timezone = null
    ) {
        if (!$timezone) {
            Dotenv::createImmutable('./.env')->load();
        }
        parent::__construct($name, array_merge([
            new StreamHandler("/logs/app.log", MonologLogger::DEBUG)
        ], $handlers), $processors, $timezone ?? $_ENV['APP_TIMEZONE']);
    }
}