<?php
declare(strict_types=1);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  NullLogger.php - Part of the php-logger project.

  © - Jitesoft 2020
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
     *
     * @return void
     */
    public function log($level, $message, array $context = array()): void {
    }

}
