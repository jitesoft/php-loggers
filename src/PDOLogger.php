<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  DatabaseLogger.php - Part of the php-logger project.

  © - Jitesoft 2017
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

namespace Jitesoft\Log;

use Jitesoft\Log\Traits\LoggerPassThroughTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use PDO;
use Psr\Log\LoggerInterface;

class DatabaseLogger implements LoggerInterface {
    use TextFormatterTrait;
    use LoggerPassThroughTrait;

    protected $pdo;

    public function __construct(PDO $databaseConnection) {
        $this->pdo = $databaseConnection;
    }


    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function log($level, $message, array $context = array()) {
        $this->pdo->


    }
}
