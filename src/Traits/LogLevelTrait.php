<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  LogLevelTrait.php - Part of the Loggers project.

  © - Jitesoft 2018
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log\Traits;

use function array_key_exists;

/**
 * LogLevelTrait
 * @author Johannes Tegnér <johannes@jitesoft.com>
 * @version 1.0.0
 */
trait LogLevelTrait {

    /** @var array */
    protected $logLevels = [
        'debug'     => 0,
        'notice'    => 1,
        'info'      => 2,
        'warning'   => 3,
        'error'     => 4,
        'critical'  => 5,
        'alert'     => 6,
        'emergency' => 7
    ];

    /** @var integer */
    protected $logLevel = 0;

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
    public function setLogLevel(string $level) {
        $this->logLevel = $this->logLevels[$level];
    }

    /**
     * Test if the logger should actually log the message due to its level.
     *
     * @param string $level Level to test.
     * @return boolean
     */
    protected function shouldLog(string $level) {
        if (!array_key_exists($level, $this->logLevels)) {
            return true; // For custom log levels.
        }

        $level = $this->logLevels[$level];
        return ($level >= $this->logLevel);
    }

}
