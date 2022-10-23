<?php
namespace Jitesoft\Log;

use Psr\Log\AbstractLogger;

abstract class StreamLogger extends AbstractLogger {
    protected $stdout;
    protected $stderr;

    /**
     * Log to streams.
     *
     * @param $errorStream ?resource Stream to log errors to. Defaults to stderr.
     * @param $outStream ?resource   Stream to log to. Defaults to stdout.
     */
    protected function __construct($errorStream = null,
                                $outStream = null) {
        $this->stderr = $errorStream ?? (defined('STDERR') ? STDERR : fopen(
            'php://stderr',
            'wb'
        ));
        $this->stdout = $outStream ?? (defined('STDOUT') ? STDOUT : fopen(
            'php://stdout',
            'wb'
        ));
    }

}
