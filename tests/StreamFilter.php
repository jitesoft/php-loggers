<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  StreamFilter.php - Part of the php-logger project.

  © - Jitesoft 2017
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log\Tests;

/**
 * Class StreamFilter
 *
 * Filter used in tests to eat the stdout/stderr output and store value in a static field.
 */
class StreamFilter extends \php_user_filter {

    public static $output;

    public function filter($in, $out, &$consumed, $closing) {
        self::$output = '';
        while ($bucket = stream_bucket_make_writeable($in)) {
            self::$output .= $bucket->data;
            $consumed     += $bucket->datalen;
            stream_bucket_append($out, $bucket);
        }

        return PSFS_FEED_ME;
    }

}
