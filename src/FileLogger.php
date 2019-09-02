<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  FileLogger.php - Part of the php-logger project.

  © - Jitesoft 2017
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

use Carbon\Carbon;
use Jitesoft\Log\Traits\LoggerPassThroughTrait;
use Jitesoft\Log\Traits\LogLevelTrait;
use Jitesoft\Log\Traits\TextFormatterTrait;
use Psr\Log\LoggerInterface;

/**
 * A Logger which writes its output to a file.
 * The logger uses the LOCK_EX flag upon writing to file.
 */
class FileLogger implements LoggerInterface {
    use TextFormatterTrait;
    use LoggerPassThroughTrait;
    use LogLevelTrait;

    /** @var string */
    public static $format = '[%s] %s: %s';
    /** @var string */
    public static $timeFormat = 'H:i:s.v';

    /** @var string */
    private $file;

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
    //phpcs:ignore Squiz.Commenting.FunctionComment
    public function log($level, $message, array $context = array()) {
        if (!$this->shouldLog($level)) {
            return;
        }

        file_put_contents(
            $this->file,
            $this->format(
                sprintf(
                    self::$format,
                    Carbon::now()->format(self::$timeFormat),
                    strtoupper($level),
                    $message
                ),
                $context
            ) . PHP_EOL, FILE_APPEND | LOCK_EX
        );
    }

}
