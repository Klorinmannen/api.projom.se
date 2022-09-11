<?php

namespace http\input;

class strings
{
    const STRING_PATTERN = '/^[\w]+$/';
    const QUERY_PATTERN = '/^[\w\/\.?=&]+$/';
    const SANITIZE_PATTERN = '/[^\w]/';

    public static function sanitize(
        string $string,
        string $pattern = ''
    ): string {

        if (!$pattern)
            $pattern = static::SANITIZE_PATTERN;

        return preg_replace($pattern, '', $string);
    }

    public static function match_pattern(
        string $subject,
        string $pattern = ''
    ): bool {

        if (!$pattern)
            $pattern = static::STRING_PATTERN;

        return preg_match($pattern, $subject) === 1;
    }
}
