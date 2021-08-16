<?php
declare(strict_types=1);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  MultiLogger.php - Part of the php-logger project.

  © - Jitesoft 2021
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

use Jitesoft\Log\Traits\LogLevelTrait;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

/**
 * A logger which acts as a wrapper around other loggers.
 *
 * This enables a single logger with many output formats.
 * Have no loggers added by default.
 *
 * @since 2.0.1
 */
class MultiLogger extends AbstractLogger {
    use LogLevelTrait;

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
    public function removeLogger(LoggerInterface|string $logger): bool {
        $name = is_string($logger) ? $logger : get_class($logger);
        if (array_key_exists($name, $this->loggers)) {
            unset($this->loggers[$name]);
            return true;
        }

        return false;
    }

    protected function innerLog(string $level,
                                string $message,
                                array $context = []): void {
        foreach ($this->loggers as $logger) {
            $logger->log($level, $message, $context);
        }
    }

}
