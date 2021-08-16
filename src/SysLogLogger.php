<?php
declare(strict_types=1);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  SysLogLogger.php - Part of the php-logger project.

  © - Jitesoft 2021
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use Psr\Log\AbstractLogger;

/**
 * Logger which logs to a syslog server.
 *
 * Default facility is the LOG_USER facility with 'unknown' ident.
 * Uses the php native syslog api.
 *
 * @since 2.0.0
 */
class SysLogLogger extends AbstractLogger {
    use TextFormatterTrait, LogLevelTrait;

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
    public function __construct(int $option   = LOG_CONS | LOG_ODELAY | LOG_PID,
                                int $facility = LOG_USER,
                                string $ident = 'unknown') {
        openlog($ident, $option, $facility);
    }

    public function __destruct() {
        closelog();
    }

    protected function innerLog(string $level,
                                string $message,
                                array $context = array()): void {
        syslog(self::LOG_PRIORITIES[$level], $this->format($message, $context));
    }

}
