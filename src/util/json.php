<?php

declare(strict_types=1);

namespace util;

use \util\file\read;

class json
{
    public static function parse(string $full_filepath): array
    {
        if (!$full_filepath)
            return [];

        $json_string = read::from_full_filepath($full_filepath);
        return static::decode($json_string);
    }

    public static function decode(
        string $json_string,
        bool $as_array = true
    ): array {

        if (!$json_string)
            return [];

        if (!$content = json_decode($json_string, $as_array))
            return [];

        return $content;
    }

    public static function encode(
        array $to_encode,
        bool $pp = false
    ): string {

        if (!$to_encode)
            return '';

        $encoded = $pp === true ? json_encode($to_encode, JSON_PRETTY_PRINT) : json_encode($to_encode);
        if (!$encoded)
            return '';

        return $encoded;
    }
}
