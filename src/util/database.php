<?php

declare(strict_types=1);

namespace util;

use \util\template;

class database
{
    public static function dsn(array $config): string
    {
        $vars = [
            'host' => $config['server_host'],
            'port' => $config['server_port'],
            'dbname' => $config['database_name']
        ];
        $dsn_template = 'mysql:host={{host}};port={{port}};dbname={{dbname}}';

        return template::bind($dsn_template, $vars);
    }
}
