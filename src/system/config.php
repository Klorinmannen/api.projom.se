<?php

declare(strict_types=1);

namespace system;

use \util\json;

class config
{
    private $_config = [];
    private $_db = [];
    private $_api = [];

    public function __construct()
    {
        $this->_load_config();
        $this->_load_db_config();
        $this->_load_api_config();
    }

    private function _load_config(): void
    {
        $filepath = str_replace('src\system', '', __DIR__) . 'config\system.json';
        if (file_exists($filepath))
            $this->_config = json::parse($filepath);
    }

    private function _load_db_config(): void
    {
        $filepath = $this->_config['config_dir'] . 'db.json';
        if (file_exists($filepath))
            $this->_db = json::parse($filepath);
    }

    private function _load_api_config(): void
    {
        $filepath = $this->_config['config_dir'] . 'api.json';
        if (file_exists($filepath))
            $this->_api = json::parse($filepath);
    }

    public function db(): array
    {
        return $this->_db;
    }

    public function api(): array
    {
        return $this->_api;
    }

    public function source_dir(): string
    {
        return $this->_config['source_dir'];
    }

    public function system_dir(): string
    {
        return $this->_config['system_dir'];
    }

    public function config_dir(): string
    {
        return $this->_config['config_dir'];
    }
}
