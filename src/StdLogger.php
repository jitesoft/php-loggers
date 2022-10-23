<?php
declare(strict_types=1);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  StdLogger.php - Part of the php-logger project.

  © - Jitesoft 2021
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

use Carbon\Carbon;
use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use Psr\Log\LogLevel;

/**
 * A logger which outputs messages to stdout and stderr.
 *
 * @since 1.0.0
 */
class StdLogger extends StreamLogger {
    use TextFormatterTrait, LogLevelTrait;

    public const DEFAULT_FORMAT      = '[%s] %s: %s' . PHP_EOL;
    public const DEFAULT_TIME_FORMAT = 'H:i:s.v';

    protected string $format;
    protected string $timeFormat;

    /**
     * StdLogger constructor.
     *
     * @param string $format     Optional string format. Defaults to [%s] %s: %s\n
     * @param string $timeFormat Optional time format. Defaults to H:i:s.v
     */
    public function __construct(string $format     = self::DEFAULT_FORMAT,
                                string $timeFormat = self::DEFAULT_TIME_FORMAT
    ) {
        parent::__construct(null, null);

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
