<?php
namespace Jitesoft\Log;

use Carbon\Carbon;
use Jitesoft\Log\Traits\CompactJsonFormatterTrait;
use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;

class CompactJsonLogger extends AbstractLogger {
    use CompactJsonFormatterTrait;
    use TextFormatterTrait;
    use LogLevelTrait;

    private $stdout;
    private $stderr;

    public function __construct($errorStream = null, $outStream = null) {
        $this->stderr = $errorStream ?? defined('STDERR') ? STDERR : fopen(
            'php://stderr',
            'wb'
        );
        $this->stdout = $outStream ?? defined('STDOUT') ? STDOUT : fopen(
            'php://stdout',
            'wb'
        );
    }

    public function log($level, $message, array $context = []): void {
        if (!array_key_exists($level, $this->logLevels)) {
            $level = 'info';
        }

        if (!$this->shouldLog($level)) {
            return;
        }
        $this->innerLog($level, $message, $context);
    }

    public function innerLog($level, $message, array $context = []): void {
        $formattedMessage = $this->format($message, $context);
        $clef             = $this->formatClef(
            $level,
            $formattedMessage,
            $message,
            Carbon::now(),
            $context
        );

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
            $stream = &$this->stderr;
        } else {
            $stream = &$this->stdout;
        }

        fwrite(
            $stream,
            $clef,
        );
    }

}
