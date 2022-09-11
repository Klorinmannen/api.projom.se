<?php

declare(strict_types=1);

namespace util\file;

use \util\validate;

class read
{
    public static function from_full_filepath(string $full_filepath): string
    {
        $pathinfo = pathinfo($full_filepath);
        if (!validate::filepath_key($pathinfo, 'filename'))
            throw new \Exception('Filename not present with path?', 500);

        if (!is_readable($full_filepath))
            throw new \Exception('File is not readable!', 500);

        if (!$string = file_get_contents($full_filepath))
            throw new \Exception('Failed to get contents!', 500);

        return $string;
    }
}
