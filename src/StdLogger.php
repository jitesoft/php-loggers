<?php
declare(strict_types=1);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  StdLogger.php - Part of the php-logger project.

  © - Jitesoft 2021
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log;

/**
 * A logger which outputs messages to stdout and stderr.
 *
 * @since 1.0.0
 */
class StdLogger extends StreamLogger {
    public const DEFAULT_FORMAT      = '[%s] %s: %s' . PHP_EOL;
    public const DEFAULT_TIME_FORMAT = 'H:i:s.v';

    /**
     * StdLogger constructor.
     *
     * @param string $format     Optional string format. Defaults to [%s] %s: %s\n
     * @param string $timeFormat Optional time format. Defaults to H:i:s.v
     */
    public function __construct(string $format     = self::DEFAULT_FORMAT,
                                string $timeFormat = self::DEFAULT_TIME_FORMAT
    ) {
        parent::__construct($format, $timeFormat, null, null);
    }

}
