<?php

declare(strict_types=1);

namespace system;

use \util\json;

class config
{
    private $_config = [];
    private $_db = [];
    private $_api = [];

    private $_system_dir = '';
    private $_config_dir = '';
    private $_source_dir = '';

    public function __construct()
    {
        $system_dir = str_replace(
            'src' . DIRECTORY_SEPARATOR . 'system',
            '',
            __DIR__
        );

        $this->_system_dir = realpath($system_dir);
        $this->_config_dir = realpath($system_dir . '/config');
        $this->_source_dir = realpath($system_dir . '/src');

        $this->_load_config();
        $this->_load_db_config();
        $this->_load_api_config();
    }

    private function _load_config(): void
    {
        $filepath = $this->_config_dir . DIRECTORY_SEPARATOR . 'system.json';
        if (file_exists($filepath))
            $this->_config = json::parse($filepath);
    }

    private function _load_db_config(): void
    {
        $filepath = $this->_config_dir . DIRECTORY_SEPARATOR . 'db.json';
        if (file_exists($filepath))
            $this->_db = json::parse($filepath);
    }

    private function _load_api_config(): void
    {
        $filepath = $this->_config_dir . DIRECTORY_SEPARATOR . 'api.json';
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
        return $this->_source_dir;
    }

    public function system_dir(): string
    {
        return $this->_system_dir;
    }

    public function config_dir(): string
    {
        return $this->_config_dir;
    }

    public function config(string $key)
    {
        return $this->_config[$key] ?? '';
    }
}
