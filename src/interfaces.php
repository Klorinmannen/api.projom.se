<?php

declare(strict_types=1);

class interfaces
{

    const CLI_ID = 1;
    const WEB_ID = 2;

    private $_inteface_id = 0;

    public function __construct()
    {
        $interface = php_sapi_name();
        if ($interface == 'cli')
            $this->_inteface_id = self::CLI_ID;
        else
            $this->_inteface_id = self::WEB_ID;
    }

    public function cli(): bool
    {
        return $this->_inteface_id == self::CLI_ID;
    }

    public function web(): bool
    {
        return $this->_inteface_id == self::WEB_ID;
    }
}
