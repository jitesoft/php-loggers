<?php
namespace Jitesoft\Log;

use Carbon\Carbon;
use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

class StreamLogger extends AbstractLogger {
    use TextFormatterTrait, LogLevelTrait;

    public const DEFAULT_FORMAT      = '[%s] %s: %s' . PHP_EOL;
    public const DEFAULT_TIME_FORMAT = 'H:i:s.v';

    protected string $format;
    protected string $timeFormat;
    protected $stdout;
    protected $stderr;

    /**
     * Log to streams.
     *
     * @param $errorStream ?resource Stream to log errors to. Defaults to stderr.
     * @param $outStream ?resource   Stream to log to. Defaults to stdout.
     */
    public function __construct(string $format = self::DEFAULT_FORMAT,
                                string $timeFormat = self::DEFAULT_TIME_FORMAT,
                                $errorStream = null,
                                $outStream = null) {
        $this->stderr = $errorStream ?? (defined('STDERR') ? STDERR : fopen(
            'php://stderr',
            'wb'
        ));
        $this->stdout = $outStream ?? (defined('STDOUT') ? STDOUT : fopen(
            'php://stdout',
            'wb'
        ));

        $this->format     = $format;
        $this->timeFormat = $timeFormat;
    }

    protected function innerLog(string $level,
                                string $message,
                                array $context = []): void {
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
            $stream = &$this->stderr;
        } else {
            $stream = &$this->stdout;
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
