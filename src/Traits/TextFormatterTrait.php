<?php
declare(strict_types=1);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
  TextFormatterTrait.php - Part of the php-logger project.

  © - Jitesoft 2021
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
namespace Jitesoft\Log\Traits;

/**
 * Trait implementing a simple formatting algorithm for logger text templates.
 *
 * Replaces all values in brackets with its corresponding value in the context array
 * and returns the formatted string.
 *
 * @since 1.0.0
 */
trait TextFormatterTrait {

    /**
     * Replaces placeholders with context values.
     *
     * @param string $message Message to format.
     * @param array  $context Context data.
     *
     * @return string
     */
    protected function format(string $message, array $context = []): string {
        $out = [];
        preg_match_all('/{(.*?)}/s', $message, $out);

        $count = count($out[1]);
        for ($i = 0;$i < $count;$i++) {
            if (array_key_exists($out[1][$i], $context)) {
                $message = str_replace(
                    $out[0][$i],
                    (string)$context[$out[1][$i]],
                    $message
                );
            }
        }

        return $message;
    }

}
