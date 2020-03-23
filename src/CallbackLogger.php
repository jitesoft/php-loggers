<?php
declare(strict_types=1);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  CallbackLogger.php - Part of the php-logger project.

  © - Jitesoft 2020
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class CallbackLogger implements LoggerInterface {
    use LoggerTrait, TextFormatterTrait, LogLevelTrait;

    private \Closure $callback;

    /**
     * CallbackLogger constructor.
     *
     * @param callable $callback Callback to call when logger is invoked.
     *                           Callback is expected to look as the following:
     *                           function (string $level,
     *                                     string $formattedMessage,
     *                                     string $message,
     *                                     array $context): void
     */
    public function __construct(callable $callback) {
        $this->callback = $callback;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param string $level   Log level to use.
     * @param string $message Message to log.
     * @param array  $context Context data.
     *
     * @return void
     */
    protected function innerLog(string $level,
                                string $message,
                                array $context = array()): void {
        call_user_func(
            $this->callback,
            $level,
            $this->format($message, $context),
            $message,
            $context
        );
    }

}
