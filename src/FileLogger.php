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
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

/**
 * A Logger which writes its output to a file.
 * The logger uses the LOCK_EX flag upon writing to file.
 */
class FileLogger implements LoggerInterface {
    use TextFormatterTrait, LoggerTrait, LogLevelTrait;

    public const FORMAT      = '[%s] %s: %s';
    public const TIME_FORMAT = 'H:i:s.v';

    private string $file;

    /**
     * FileLogger constructor.
     * @param string $file File to log to.
     */
    public function __construct(string $file = '/tmp/log.txt') {
        $this->file = $file;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level   Log level to use.
     * @param string $message Message to log.
     * @param array  $context Context data.
     * @return void
     */
    public function log($level, $message, array $context = array()): void {
        if (!$this->shouldLog($level)) {
            return;
        }

        file_put_contents(
            $this->file,
            $this->format(
                sprintf(
                    self::FORMAT,
                    Carbon::now()->format(self::TIME_FORMAT),
                    strtoupper($level),
                    $message
                ),
                $context
            ) . PHP_EOL, FILE_APPEND | LOCK_EX
        );
    }

}
