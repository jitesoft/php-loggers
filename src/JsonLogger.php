<?php
declare(strict_types=1);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  JsonLogger.php - Part of the php-logger project.

  © - Jitesoft 2021
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

use Carbon\Carbon;
use Jitesoft\Log\Traits\JsonFormatterTrait;
use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

/**
 * A logger which outputs json formatted messages to stdout and stderr.
 *
 * The following logging format is used:
 * <pre>
 * { "severity": "error", "message": "Formatted message.", "context": { }, "time": "1977-04-22T06:00:00Z", "ts": 230533200 }
 * </pre>
 *
 * @since 2.3.0
 */
class JsonLogger extends AbstractLogger {
    use TextFormatterTrait, LogLevelTrait, JsonFormatterTrait;

    private $outStream;
    private $errorStream;

    public function __construct() {
        $this->errorStream = defined('STDERR') ? STDERR : fopen(
            'php://stderr',
            'wb'
        );
        $this->outStream   = defined('STDOUT') ? STDOUT : fopen(
            'php://stdout',
            'wb'
        );
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
                LogLevel::ERROR,
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
            $this->formatJson(
                $level,
                $this->format($message, $context),
                Carbon::now(),
                $context
            )
        );
    }

}
