<?php
namespace Jitesoft\Log;

use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class SysLogLogger implements LoggerInterface {
    use TextFormatterTrait;
    use LoggerTrait;
    use LogLevelTrait;

    /** @var array LogPriorities map. */
    private static $logPriorities = [
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
    // phpcs:ignore Squiz.Commenting.FunctionComment
    public function log($level, $message, array $context = array()) {
        syslog(self::$logPriorities[$level], $this->format($message, $context));
    }

}
