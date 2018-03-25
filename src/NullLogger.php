<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  NullLogger.php - Part of the php-logger project.

  © - Jitesoft 2017
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

use Jitesoft\Log\Traits\LoggerPassThroughTrait;
use Psr\Log\LoggerInterface;

/**
 * A logger doing absolutely nothing, and its not even supposed to!
 *
 * @codeCoverageIgnore
 */
class NullLogger implements LoggerInterface {
    use LoggerPassThroughTrait;

    public function log($level, $message, array $context = array()) {

    }

}
