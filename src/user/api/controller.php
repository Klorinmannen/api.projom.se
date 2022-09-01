<?php

declare(strict_types=1);

namespace user\api;

class controller extends \api\resource\controller
{
    public function login()
    {
        if (!$input_data = $this->_json_data)
            throw new \Exception('Missing username/password', 400);

        if (!$username = \util\validate::string_key($input_data, 'username'))
            throw new \Exception('Missing username/password', 400);

        if (!$password = \util\validate::string_key($input_data, 'password'))
            throw new \Exception('Missing username/password', 400);

        $user_data = [
            'username' => $username,
            'password' => $password
        ];

        $response = $this->response($user_data);

        if (!$this->validate($response))
            throw new \Exception('Response not valid', 500);

        return $response;
    }

    public function response(array $user_data): array
    {
        if (!$user = static::authenticate($user_data['username'], $user_data['password']))
            throw new \Exception('Failed to login', 400);

        $response['username'] = $user['username'];
        $response['jwt'] = \util\jwt::create($user['UserID'], $user['JWTKey']);

        return $response;
    }

    public static function authenticate(
        string $username,
        string $password
    ): array {

        if (!$username || !$password)
            throw new \Exception('Missing username/password');

        if (!$user = \user\model::search_by_username($username))
            throw new \Exception('Invalid username/password');

        if (!\user\password::verify($password, $user['Password']))
            throw new \Exception('Invalid username/password');

        return $user;
    }

    public function validate(array $response): bool
    {
        if (!$response['jwt'])
            return false;
        if (!$response['username'])
            return false;
        return true;
    }
}
