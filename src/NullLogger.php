<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  NullLogger.php - Part of the php-logger project.

  © - Jitesoft 2017
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

/**
 * A logger doing absolutely nothing, and its not even supposed to!
 *
 * @codeCoverageIgnore
 */
class NullLogger implements LoggerInterface {
    use LoggerTrait;

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level Log level of message.
     * @param string $message Message to log.
     * @param array  $context Context data.
     */
    // phpcs:ignore Squiz.Commenting.FunctionComment
    public function log($level, $message, array $context = array()) {
    }

}
