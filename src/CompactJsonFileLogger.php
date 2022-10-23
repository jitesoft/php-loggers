<?php
namespace Jitesoft\Log;

use Carbon\Carbon;
use Jitesoft\Log\Traits\CompactJsonFormatterTrait;
use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use Psr\Log\AbstractLogger;

/**
 * A logger which outputs compact json log messages to a file without rotation.
 *
 * Each log entry is printed on a new line as a json object with the following format:
 * <pre>
 * {"@t":"DateTime as ISO8601 String","@l":(int)level,"@m":"Formatted message","@mt":"Message template","@r":(array)context}
 * </pre>
 * The logger uses the file_put_contents function with the LOCK_EX flag upon writing to file.
 *
 * @since 4.0.0
 */
class CompactJsonFileLogger extends AbstractLogger {
    use CompactJsonFormatterTrait;
    use TextFormatterTrait;
    use LogLevelTrait;

    protected string $file;

    /**
     * Log to file with compact json (CLEF - Compact Log Event Format).
     *
     * @param string $file File to write to.
     */
    public function __construct(string $file = '/tmp/log.clef') {
        $this->file = $file;
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

        file_put_contents(
            $this->file,
            $clef . PHP_EOL,
            FILE_APPEND | LOCK_EX
        );
    }

}
