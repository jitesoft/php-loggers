<?php

namespace Jitesoft\Log;

use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class CallbackLogger implements LoggerInterface {
    use LoggerTrait, TextFormatterTrait, LogLevelTrait;
    private \Closure $callback;

    public function __construct(callable $callback) {
        $this->callback = $callback;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level   Log level to use.
     * @param string $message Message to log.
     * @param array  $context Context data.
     * @return void
     */
    public function log($level, $message, array $context = array()): void {
        call_user_func(
            $this->callback,
            $level,
            $this->format($message, $context),
            $message,
            $context
        );
    }

}
