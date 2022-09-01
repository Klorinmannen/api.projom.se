<?php

declare(strict_types=1);

class system
{
    public static function init(): void
    {
        $interface_id = static::interface_id();
        if ($interface_id != \interfaces::WEB_ID)
            return;
            
        $_SESSION['request'] = \http\request::init();
        $_SESSION['user'] = \user::init();
        $_SESSION['config'] = \system\config::init();
    }

    public static function interface_id()
    {
        $interface = php_sapi_name();
        if ($interface == 'cli')
            return \interfaces::CLI_ID;
        return \interfaces::WEB_ID;
    }

    public static function config(): object
    {
        return $_SESSION['config'];
    }
}
