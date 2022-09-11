<?php

declare(strict_types=1);

namespace util;

use util\database;

class pdo
{
    public static function init(array $config): object
    {
        $dsn = database::dsn($config);
        $driver_options = static::driver_opts();

        $pdo = new \PDO(
            $dsn,
            $config['username'],
            $config['password'],
            $driver_options
        );

        if (!$pdo)
            throw new \Exception('Failed to create pdo');

        return $pdo;
    }

    private static function driver_opts(): array
    {
        return [
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ];
    }
}
