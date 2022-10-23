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
 * @since 2.3.0
 */
trait JsonFormatterTrait {
    private static int $jsonParams
        = JSON_INVALID_UTF8_SUBSTITUTE | JSON_BIGINT_AS_STRING;

    /**
     * Set json params used when internally converting log record from array  to json.
     * Defaults to JSON_INVALID_UTF8_SUBSTITUTE | JSON_BIGINT_AS_STRING
     *
     * @param int $params Json parameters to use in conversion.
     * Bitmask consisting of <b>JSON_HEX_QUOT</b>,
     * <b>JSON_HEX_TAG</b>,
     * <b>JSON_HEX_AMP</b>,
     * <b>JSON_HEX_APOS</b>,
     * <b>JSON_NUMERIC_CHECK</b>,
     * <b>JSON_PRETTY_PRINT</b>,
     * <b>JSON_UNESCAPED_SLASHES</b>,
     * <b>JSON_FORCE_OBJECT</b>,
     * <b>JSON_UNESCAPED_UNICODE</b>.
     * <b>JSON_THROW_ON_ERROR</b> The behaviour of these
     * constants is described on
     * the JSON constants page.
     * @return void
     */
    public static function setJsonParams(int $params): void {
        self::$jsonParams = $params;
    }

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
