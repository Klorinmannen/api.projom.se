<?php

declare(strict_types=1);

class system
{
    private $_config = null;
    private $_log = null;

    public function __construct()
    { 
        $this->_config = new \system\config();
        $this->_log = new \system\log($this->_config->db());
    }

    public function config(): object
    {
        return $this->_config;
    }

    public function log(): object
    {
        return $this->_log;
    }
}
