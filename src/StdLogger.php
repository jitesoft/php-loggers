<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  StdLogger.php - Part of the php-logger project.

  © - Jitesoft 2017
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

use Carbon\Carbon;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class StdLogger implements LoggerInterface {

    public static $format     = '[%s] %s: %s';
    public static $timeFormat = 'H:i:s.v';

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function emergency($message, array $context = array()) {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function alert($message, array $context = array()) {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function critical($message, array $context = array()) {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function error($message, array $context = array()) {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function warning($message, array $context = array()) {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function notice($message, array $context = array()) {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function info($message, array $context = array()) {
        $this->log(LogLevel::INFO, $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function debug($message, array $context = array()) {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param string $level
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function log($level, $message, array $context = array()) {
        $handle = null;
        if (in_array($level, [LogLevel::EMERGENCY, LogLevel::CRITICAL, LogLevel::ALERT, LogLevel::ERROR])) {
            $handle = STDERR;
        } else {
            $handle = STDOUT;
        }

        fwrite($handle,
            $this->format(
                sprintf(self::$format, Carbon::now()->format(self::$timeFormat), strtoupper($level), $message),
                $context
            )
        );
    }

    protected function format($message, $context): string {
        $out = [];
        preg_match_all('/{(.*?)}/s', $message, $out);

        $count = count($out[1]);
        for ($i=0;$i<$count;$i++) {
            if (array_key_exists($out[1][$i], $context)) {
                $message = str_replace($out[0][$i], $context[$out[1][$i]], $message);
            }
        }

        return $message;
    }

}
