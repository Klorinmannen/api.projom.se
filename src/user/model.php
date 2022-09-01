<?php

declare(strict_types=1);

namespace user;

class model
{
    public static function add(array $fields): int
    {
        $table = new \util\table('User');
        return $table->insert($fields)->requery('UserID');
    }

    public static function search_by_username(string $username): array
    {
        $table = new \util\table('User');
        return $table->select()->where(['Username' => $username, 'Deleted' => 0])->query();
    }

    public static function update(
        int $user_id,
        array $fields
    ): int {
        $table = new \util\table('User');
        return $table->update($fields)->where(['UserID' => $user_id])->query();
    }

    public static function user(int $user_id): array
    {
        $table = new \util\table('User');
        return $table->select()->where(['UserID' => $user_id])->query();
    }
}
