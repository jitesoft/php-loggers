<?php

namespace Jitesoft\Log\Traits;

use Carbon\Carbon;
use Exception;

trait CompactJsonFormatterTrait {
    public static int $jsonParams
        = JSON_INVALID_UTF8_SUBSTITUTE | JSON_BIGINT_AS_STRING;

    private static $logPriorities = [
        'debug'     => LOG_DEBUG,
        'notice'    => LOG_NOTICE,
        'info'      => LOG_INFO,
        'warning'   => LOG_WARNING,
        'error'     => LOG_ERR,
        'critical'  => LOG_CRIT,
        'alert'     => LOG_ALERT,
        'emergency' => LOG_EMERG
    ];

    /**
     * @param string         $level
     * @param string         $formattedMessage
     * @param Carbon         $time
     * @param array|mixed[]  $context
     * @return string
     */
    protected function formatClef(string $level,
        string $formattedMessage,
        string $messageTemplate,
        Carbon $time,
        array $context = []): string {
        $arr = [
            '@t'  => $time->toIso8601String(),
            '@l'  => self::$logPriorities[$level],
            '@m'  => $formattedMessage,
            '@mt' => $messageTemplate,
            '@r'  => $context,
        ];

        return json_encode($arr, self::$jsonParams, 4);
    }

}
