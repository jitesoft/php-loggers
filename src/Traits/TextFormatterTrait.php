<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  TextFormatterTrait.php - Part of the php-logger project.

  © - Jitesoft 2017
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log\Traits;

/**
 * Trait TextFormatterTrait
 * @package Jitesoft\Log\Traits
 *
 * Trait implementing a simple formatting algorithm for logger text templates.
 */
trait TextFormatterTrait {

    protected function format(string $message, array $context = []): string {
        $out = [];
        preg_match_all('/{(.*?)}/s', $message, $out);

        $count = count($out[1]);
        for ($i=0;$i<$count;$i++) {
            if (array_key_exists($out[1][$i], $context)) {
                $message = str_replace($out[0][$i], $context[$out[1][$i]], $message);
            }
        }

        return $message;
    }

}
