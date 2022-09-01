<?php

declare(strict_types=1);

class user
{
    private $_username = 'System';
    private $_email = 'System';
    private $_user_id = 1;

    public function __construct(array $record = [])
    {
        self::init_from_record($record);
    }

    private function init_from_record(array $record): void
    {
        if (!$record)
            return;

        $this->_email = $record['Email'];
        $this->_username = $record['Username'];
        $this->_user_id = $record['UserID'];
        $this->_record = $record;
    }

    public static function init(): object
    {
        return new \user();
    }
    
    public static function get(): object
    {
        return $_SESSION['user'];
    }

    public function set_email(string $email): void
    {
        $this->_email = $email;
    }

    public function set_username(string $username): void
    {
        $this->_username = $username;
    }

    public function email(): string
    {
        return $this->_email;
    }

    public function username(): string
    {
        return $this->_username;
    }

    public function user_id(): int
    {
        return $this->_user_id;
    }

    public function logout(): void
    {
        session_unset();
        $this->redirect('/');
    }

    public function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }
}
