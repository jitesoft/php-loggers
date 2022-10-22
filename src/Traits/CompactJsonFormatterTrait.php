<?php
namespace Jitesoft\Log\Traits;

use Carbon\Carbon;

trait CompactJsonFormatterTrait {
    public static int $jsonParams
        = JSON_INVALID_UTF8_SUBSTITUTE | JSON_BIGINT_AS_STRING;

    private static $logPriorities = [
        'debug'     => 'Verbose',
        'notice'    => 'Debug',
        'info'      => 'Information',
        'warning'   => 'Warning',
        'error'     => 'Error',
        'critical'  => 'Error',
        'alert'     => 'Fatal',
        'emergency' => 'Fatal'
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
