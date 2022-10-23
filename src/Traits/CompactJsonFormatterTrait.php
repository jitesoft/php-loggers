<?php
namespace Jitesoft\Log\Traits;

use Carbon\Carbon;

trait CompactJsonFormatterTrait {
    protected static int $jsonParams
        = JSON_INVALID_UTF8_SUBSTITUTE | JSON_BIGINT_AS_STRING;

    protected static string $extraPrefix = '_';
    protected static bool $includeExtra  = true;
    protected static array $extra        = [];

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

    /**
     * Toggle extra context parameters.
     * Extra parameters are the parameters included in the context logged as
     * well as the parameters set in the static @see setExtra in this class.
     *
     * @param bool $state
     * @return void
     */
    public static function setIncludeExtra(bool $state): void {
        self::$includeExtra = $state;
    }

    /**
     * Set prefix to use on extra context parameters.
     * Extra parameters are the parameters included in the context logged as
     * well as the parameters set in the static @see setExtra in this class.
     *
     * @param string $prefix Prefix to use, defaults to "_"
     * @return void
     */
    public static function setExtraPrefix(string $prefix): void {
        self::$extraPrefix = $prefix;
    }

    /**
     * Extra parameters to pass to the logger in the resulting payload.
     *
     * @param array $extra Key value of extra values.
     * @return void
     */
    public static function setExtra(array $extra): void {
        self::$extra = $extra;
    }

    private static array $logPriorities = [
        'debug'     => 'Verbose',
        'notice'    => 'Debug',
        'info'      => 'Information',
        'warning'   => 'Warning',
        'error'     => 'Error',
        'critical'  => 'Error',
        'alert'     => 'Fatal',
        'emergency' => 'Fatal'
    ];

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

        if (self::$includeExtra) {
            foreach (array_merge($context, self::$extra) as $key => $value) {
                $arr[self::$extraPrefix . $key] = $value;
            }
        }

        return json_encode($arr, self::$jsonParams, 4);
    }

}
