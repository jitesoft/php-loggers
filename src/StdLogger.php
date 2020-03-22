<?php
declare(strict_types=1);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  StdLogger.php - Part of the php-logger project.

  © - Jitesoft 2020
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

use Carbon\Carbon;
use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;

/**
 * A logger which outputs messages to stdout and stderr.
 */
class StdLogger implements LoggerInterface {
    use TextFormatterTrait, LoggerTrait, LogLevelTrait;

    public const FORMAT      = '[%s] %s: %s';
    public const TIME_FORMAT = 'H:i:s.v';

    /**
     * Logs with an arbitrary level.
     *
     * @param string $level   Log level to use.
     * @param string $message Message to log.
     * @param array  $context Context data.
     *
     * @return void
     */
    // phpcs:ignore Squiz.Commenting.FunctionComment
    public function log($level, $message, array $context = array()): void {
        if (!$this->shouldLog($level)) {
            return;
        }

        $handle = null;
        if (in_array(
            $level,
            [
                LogLevel::EMERGENCY,
                LogLevel::CRITICAL,
                LogLevel::ALERT,
                LogLevel::ERROR
            ],
            true
        )
        ) {
            $handle = STDERR;
        } else {
            $handle = STDOUT;
        }

        fwrite(
            $handle,
            $this->format(
                sprintf(
                    self::FORMAT,
                    Carbon::now()->format(self::TIME_FORMAT),
                    strtoupper($level),
                    $message
                ),
                $context
            )
        );
    }

}
