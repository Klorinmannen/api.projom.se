<?php

declare(strict_types=1);

namespace http\input;

class integers
{
    const ID_PATTERN = '/^[0-9]+$/';
    const INT_PATTERN = '/^-?[0-9]+$/';

    public static function match_pattern(
        int $subject,
        string $pattern = ''
    ): bool {

        if (!$pattern)
            $pattern = static::INT_PATTERN;

        return (preg_match($pattern, (string)$subject) === 1);
    }
}
