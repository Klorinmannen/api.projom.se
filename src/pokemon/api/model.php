<?php

declare(strict_types=1);

namespace pokemon\api;

class model
{    
    public static function list(array $fields): array
    {
        $table = new \util\table('Pokemon');
        return $table->select($fields)->where('Active <> 0')->query();
    }
}
