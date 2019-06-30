<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  StdLogger.php - Part of the php-logger project.

  © - Jitesoft 2017
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

use Carbon\Carbon;
use Jitesoft\Log\Traits\LoggerPassThroughTrait;
use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * A logger which outputs messages to stdout and stderr.
 */
class StdLogger implements LoggerInterface {
    use TextFormatterTrait;
    use LoggerPassThroughTrait;
    use LogLevelTrait;

    public static $format     = '[%s] %s: %s';
    public static $timeFormat = 'H:i:s.v';

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
    public function log($level, $message, array $context = array()) {
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
            ])
        ) {
            $handle = STDERR;
        } else {
            $handle = STDOUT;
        }

        fwrite($handle,
            $this->format(
                sprintf(
                    self::$format,
                    Carbon::now()->format(self::$timeFormat),
                    strtoupper($level),
                    $message
                ),
                $context
            )
        );
    }

}
