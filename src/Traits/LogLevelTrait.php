<?php
declare(strict_types=1);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  LogLevelTrait.php - Part of the Loggers project.

  © - Jitesoft 2021
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log\Traits;

/**
 * Trait handling different log levels and helpers for loggers.
 *
 * @since 1.0.0
 */
trait LogLevelTrait {
    protected int $logLevel    = 0;
    protected array $logLevels = [
        'debug'     => 0,
        'notice'    => 1,
        'info'      => 2,
        'warning'   => 3,
        'error'     => 4,
        'critical'  => 5,
        'alert'     => 6,
        'emergency' => 7
    ];

    /**
     * Set the log level of the logger.
     * Anything above or equal to the set level will be logged.
     *
     * Available levels:
     * debug, notice, info, warning, error, critical, alert, emergency
     *
     * @param string $level Level to use.
     * @return void
     */
    public function setLogLevel(string $level): void {
        $this->logLevel = $this->logLevels[$level];
    }

    /**
     * Test if the logger should actually log the message due to its level.
     *
     * @param string $level Level to test.
     * @return boolean
     */
    protected function shouldLog(string $level): bool {
        if (!array_key_exists($level, $this->logLevels)) {
            return true; // For custom log levels.
        }

        $intLevel = $this->logLevels[$level];
        return ($intLevel >= $this->logLevel);
    }

    /**
     * @inheritDoc
     */
    public function log($level, $message, array $context = array()): void {
        if (!$this->shouldLog($level)) {
            return;
        }
        $this->innerLog($level, $message, $context);
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
    abstract protected function innerLog(
        string $level,
        string $message,
        array $context
    ): void;

}
