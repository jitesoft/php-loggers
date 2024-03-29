<?php
namespace Jitesoft\Log;

use Carbon\Carbon;
use Jitesoft\Log\Traits\CompactJsonFormatterTrait;
use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use Psr\Log\LogLevel;

/**
 * A logger which outputs compact json log messages to streams.
 *
 * Each log entry is printed on a new line as a json object with the following format:
 * <pre>
 * {"@t":"DateTime as ISO8601 String","@l":(int)level,"@m":"Formatted message","@mt":"Message template","@r":(array)context}
 * </pre>
 *
 * @since 4.0.0
 */
class CompactJsonLogger extends StreamLogger {
    use CompactJsonFormatterTrait;
    use TextFormatterTrait;
    use LogLevelTrait;

    /**
     * Log to streams with compact json (CLEF - Compact Log Event Format).
     *
     * @param $errorStream ?resource Stream to log errors to. Defaults to stderr.
     * @param $outStream ?resource   Stream to log to. Defaults to stdout.
     */
    public function __construct($errorStream = null, $outStream = null) {
        parent::__construct($errorStream, $outStream);
    }

    protected function innerLog($level, $message, array $context = []): void {
        if (!array_key_exists($level, $this->logLevels)) {
            $level = 'info';
        }

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
