<?php
// phpcs:ignoreFile -- Test file
namespace Jitesoft\Log\Tests;

class StreamFilter extends \php_user_filter {

    public static $output;

    public function filter($in, $out, &$consumed, bool $closing): int {
        self::$output = '';
        while ($bucket = stream_bucket_make_writeable($in)) {
            self::$output .= $bucket->data;
            $consumed     += $bucket->datalen;
            stream_bucket_append($out, $bucket);
        }

        return PSFS_FEED_ME;
    }

}
