<?php

namespace Jitesoft\Log\Traits;

use Carbon\Carbon;

/**
 * Trait used to create a standardized json log message.
 *
 * The json encoder is passed the following flags: JSON_INVALID_UTF8_SUBSTITUTE | JSON_BIGINT_AS_STRING.
 * The json format looks as following:
 * <pre>
 * { "severity": "error", "message": "Formatted message.", "context": { }, "time": "1977-04-22T06:00:00Z", "ts": 230533200 }
 * </pre>
 *
 * @since 3.0.0
 */
trait JsonFormatterTrait {

    public static int $jsonParams
        = JSON_INVALID_UTF8_SUBSTITUTE | JSON_BIGINT_AS_STRING;

    /**
     * @param string $level
     * @param string $formattedMessage
     * @param Carbon $time
     * @param array  $context
     * @return string
     */
    protected function formatJson(string $level,
                                  string $formattedMessage,
                                  Carbon $time,
                                  array $context = []): string {
        $arr = [
            'severity' => mb_strtolower($level),
            'message'  => $formattedMessage,
            'context'  => $context,
            'time'     => $time->toISOString(),
            'ts'       => $time->timestamp,
        ];

        return json_encode($arr, self::$jsonParams, 32);
    }

}
