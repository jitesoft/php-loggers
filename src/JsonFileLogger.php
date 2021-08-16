<?php
declare(strict_types=1);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  JsonFileLogger.php - Part of the php-logger project.

  © - Jitesoft 2021
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

use Carbon\Carbon;
use Jitesoft\Log\Traits\JsonFormatterTrait;
use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use Psr\Log\AbstractLogger;

/**
 * A logger which outputs json log messages to a file without rotation.
 *
 * Each log entry is printed on a new line as a json object with the following format:
 * <pre>
 * { "severity": "error", "message": "Formatted message.", "context": { }, "time": "1977-04-22T06:00:00Z", "ts": 230533200 }
 * </pre>
 * The logger uses the file_put_contents function with the LOCK_EX flag upon writing to file.
 *
 * @since 3.0.0
 */
class JsonFileLogger extends AbstractLogger {
    use TextFormatterTrait, LogLevelTrait, JsonFormatterTrait;

    private string $file;

    public function __construct(string $file = '/tmp/log.json') {
        $this->file = $file;
    }

    protected function innerLog(string $level,
                                string $message,
                                array $context): void {
        file_put_contents(
            $this->file,
            $this->formatJson(
                $level,
                $this->format($message, $context),
                Carbon::now(),
                $context
            ) . PHP_EOL, FILE_APPEND | LOCK_EX
        );
    }

}
