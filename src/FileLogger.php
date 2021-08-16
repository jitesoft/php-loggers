<?php
declare(strict_types=1);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  FileLogger.php - Part of the php-logger project.

  © - Jitesoft 2020
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

use Carbon\Carbon;
use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use Psr\Log\AbstractLogger;

/**
 * A Logger which writes its output to a file.
 *
 * The logger uses the file_put_contents function with the LOCK_EX flag upon writing to file.
 * Each new log entry ends with a new line and the file is appended without rotation.
 *
 * @since 1.0.0
 */
class FileLogger extends AbstractLogger {
    use TextFormatterTrait, LogLevelTrait;

    public const DEFAULT_FORMAT      = '[%s] %s: %s';
    public const DEFAULT_TIME_FORMAT = 'H:i:s.v';

    private string $file;
    private string $timeFormat;
    private string $format;

    /**
     * FileLogger constructor.
     *
     * @param string $file       File to log to.
     * @param string $format     Format to use in log message. Defaults to [%s] %s: %s
     * @param string $timeFormat Format for time string to use in log message. Defaults to H:i:s.v
     */
    public function __construct(string $file       = '/tmp/log.txt',
                                string $format     = self::DEFAULT_FORMAT,
                                string $timeFormat = self::DEFAULT_TIME_FORMAT
    ) {
        $this->file       = $file;
        $this->format     = $format;
        $this->timeFormat = $timeFormat;
    }

    protected function innerLog(string $level,
                                string $message,
                                array $context = []): void {
        file_put_contents(
            $this->file,
            $this->format(
                sprintf(
                    $this->format,
                    Carbon::now()->format($this->timeFormat),
                    strtoupper($level),
                    $message
                ),
                $context
            ) . PHP_EOL, FILE_APPEND | LOCK_EX
        );
    }

}
