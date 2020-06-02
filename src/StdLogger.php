<?php
declare(strict_types=1);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  StdLogger.php - Part of the php-logger project.

  © - Jitesoft 2020
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

use Carbon\Carbon;
use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;
use Psr\Log\LogLevel;

/**
 * A logger which outputs messages to stdout and stderr.
 */
class StdLogger implements LoggerInterface {
    use TextFormatterTrait, LoggerTrait, LogLevelTrait;

    public const DEFAULT_FORMAT      = '[%s] %s: %s' . PHP_EOL;
    public const DEFAULT_TIME_FORMAT = 'H:i:s.v';

    private string $format;
    private string $timeFormat;
    /** @var resource */
    private $outStream;
    /** @var resource */
    private $errorStream;

    /**
     * StdLogger constructor.
     *
     * @param string $format     Optional string format. Defaults to [%s] %s: %s\n
     * @param string $timeFormat Optional time format. Defaults to H:i:s.v
     */
    public function __construct(string $format = self::DEFAULT_FORMAT,
                                string $timeFormat = self::DEFAULT_TIME_FORMAT
    ) {
        $this->format      = $format;
        $this->timeFormat  = $timeFormat;
        $this->errorStream = defined('STDERR') ? STDERR : fopen(
            'php://stderr',
            'wb'
        );
        $this->outStream   = defined('STDOUT') ? STDOUT : fopen(
            'php://stdout',
            'wb'
        );
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
        $stream = null;
        if (in_array(
            $level,
            [
                LogLevel::EMERGENCY,
                LogLevel::CRITICAL,
                LogLevel::ALERT,
                LogLevel::ERROR
            ],
            true
        )
        ) {
            $stream = &$this->errorStream;
        } else {
            $stream = &$this->outStream;
        }

        fwrite(
            $stream,
            $this->format(
                sprintf(
                    $this->format,
                    Carbon::now()->format($this->timeFormat),
                    strtoupper($level),
                    $message
                ),
                $context
            )
        );
    }

}
