<?php
declare(strict_types=1);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  MultiLogger.php - Part of the php-logger project.

  © - Jitesoft 2020
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

use Jitesoft\Log\Traits\LogLevelTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class MultiLogger implements LoggerInterface {
    use LoggerTrait, LogLevelTrait;

    /** @var array|LoggerInterface[] */
    private array $loggers = [];

    public function __construct(array $loggers = []) {
        foreach ($loggers as $logger) {
            $this->addLogger($logger);
        }
    }

    /**
     * Add a specific logger to the multi-logger.
     *
     * @param LoggerInterface $logger Logger to add.
     * @param string|null     $name   Optional name to use for the logger.
     */
    public function addLogger(LoggerInterface $logger,
                              string $name = null): void {
        $name                 = $name ?? get_class($logger);
        $this->loggers[$name] = $logger;
    }

    /**
     * Remove a specific logger from the multi-logger.
     *
     * @param LoggerInterface|string $logger Logger to remove.
     * @return boolean
     */
    public function removeLogger($logger): bool {
        $name = is_string($logger) ? $logger : get_class($logger);
        if (array_key_exists($name, $this->loggers)) {
            unset($this->loggers[$name]);
            return true;
        }

        return false;
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
        foreach ($this->loggers as $logger) {
            $logger->log($level, $message, $context);
        }
    }

}
