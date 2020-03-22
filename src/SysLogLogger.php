<?php
declare(strict_types=1);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  SysLogLogger.php - Part of the php-logger project.

  © - Jitesoft 2020
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class SysLogLogger implements LoggerInterface {
    use TextFormatterTrait, LoggerTrait, LogLevelTrait;

    private const LOG_PRIORITIES = [
        'debug'     => LOG_DEBUG,
        'notice'    => LOG_NOTICE,
        'info'      => LOG_INFO,
        'warning'   => LOG_WARNING,
        'error'     => LOG_ERR,
        'critical'  => LOG_CRIT,
        'alert'     => LOG_ALERT,
        'emergency' => LOG_EMERG
    ];

    /**
     * SysLogLogger constructor.
     *
     * @param integer $option   Options to pass to syslog.
     * @param integer $facility Syslog facility.
     * @param string  $ident    App identity.
     */
    public function __construct(int $option = LOG_CONS | LOG_ODELAY | LOG_PID,
                                int $facility = LOG_USER,
                                string $ident = 'unknown') {
        openlog($ident, $option, $facility);
    }

    /**
     * Destructor.
     */
    public function __destruct() {
        closelog();
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
        syslog(self::LOG_PRIORITIES[$level], $this->format($message, $context));
    }

}
