<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  LoggerPassthroughTrait.php - Part of the php-logger project.

  © - Jitesoft 2017
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log\Traits;

use Psr\Log\LogLevel;

/**
 * Trait LoggerPassthroughTrait
 * @package Jitesoft\Log\Traits
 */
trait LoggerPassThroughTrait {
// phpcs:disable Squiz.Commenting.FunctionComment

    /**
     * System is unusable.
     *
     * @param string $message Message to write.
     * @param array  $context Message context data.
     *
     * @return void
     */
    public function emergency($message, array $context = array()): void {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message Message to write.
     * @param array  $context Context data.
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
     * @param string $message Message to write.
     * @param array  $context Context data.
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
     * @param string $message Message to write.
     * @param array  $context Context data.
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
     * @param string $message Message to write.
     * @param array  $context Context data.
     *
     * @return void
     */
    public function warning($message, array $context = array()) {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message Message to write.
     * @param array  $context Context data.
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
     * @param string $message Message to write.
     * @param array  $context Context data.
     *
     * @return void
     */
    public function info($message, array $context = array()) {
        $this->log(LogLevel::INFO, $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message Message to write.
     * @param array  $context Context data.
     *
     * @return void
     */
    public function debug($message, array $context = array()) {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

// phpcs:enable
}
