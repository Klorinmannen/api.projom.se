<?php

declare(strict_types=1);

namespace http;

class request
{
    public const API_REQ = 1;
    public const PAGE_REQ = 2;
    public const EMPTY_REQ = 3;
    public const DOCS_PATTERN = '/^\/docs/';

    protected $_parsed_url = [];
    protected $_query_params = [];
    protected $_json_data = [];
    protected $_input_data = '';
    protected $_url = '';
    protected $_url_path = '';
    protected $_auth_header = '';
    protected $_method = '';
    protected $_type = 0;
    protected $_hostname = '';

    public function __construct()
    {
        $this->_method = $_SERVER['REQUEST_METHOD'];
        $this->_url = $_SERVER['REQUEST_URI'];
        self::parse_url();
        self::parse_headers();
        self::set_data();
        self::set_type($this->_url_path);
        self::set_url_path_parts();
    }

    private function parse_url(): void
    {
        $this->_parsed_url = parse_url($this->_url);
        if ($query = \util\validate::query_key($this->_parsed_url, 'query'))
            parse_str($query, $this->_query_params);
        if ($path = \util\validate::query_key($this->_parsed_url, 'path'))
            $this->_url_path = ltrim($path, '/');
        if ($hostname = \util\validate::query_key($this->_parsed_url, 'host'))
            $this->_hostname = trim($hostname);
    }

    private function parse_headers(): void
    {
        $headers = apache_request_headers();
        if (isset($headers['Authorization']))
            $this->_auth_header = str_replace('Bearer ', '', $headers['Authorization']);
    }

    private function set_data(): void
    {
        $this->_input_data = file_get_contents('php://input');

        switch ($this->_method) {
            case 'POST':
            case 'PUT':
            case 'PATCH':
                if ($this->_input_data)
                    $this->_json_data = \util\json::decode($this->_input_data);

                break;
            default:
                $this->_input_data = '';
                break;
        }
    }

    private function set_type(string $path): void
    {
        if (\util\strings::match_pattern($path, self::DOCS_PATTERN))
            $this->_type = self::PAGE_REQ;
        elseif (!$this->_url_path)
            $this->_type = self::EMPTY_REQ;
        else
            $this->_type = self::API_REQ;
    }

    private function set_url_path_parts()
    {
        $this->_url_path_parts = explode('/', ltrim($this->_url_path, '/'));
    }

    public function get_query_param(string $param): ?string
    {
        if (!$query_param = \util\validate::string_key($this->_query_params, $param))
            return null;
        return $query_param;
    }

    public function query_parameters(): array
    {
        return $this->_query_params;
    }
    public function url_path(): string
    {
        return $this->_url_path;
    }
    public function url_path_parts(): array
    {
        return $this->_url_path_parts;
    }
    public function url(): string
    {
        return $this->_url;
    }
    public function method(): string
    {
        return $this->_method;
    }
    public function lang(): string
    {
        return $this->lang;
    }
    public function json_data(): array
    {
        return $this->_json_data;
    }
    public function header_auth(): string
    {
        return $this->_auth_header;
    }
    public function type(): int
    {
        return $this->_type;
    }
    public function hostname(): string
    {
        return $this->_hostname;
    }

    public function api(): bool
    {
        return $this->_type == self::API_REQ;
    }

    public function empty(): bool
    {
        return $this->_type == self::EMPTY_REQ;
    }

    public function redirect(string $place): void
    {   
        $header = 'Location: '.$place;
        header($header, true, 301);
        exit;
    }

    public static function init(): void
    {
        $_SESSION['request'] = new \http\request();
    }
    public static function get(): object
    {
        return $_SESSION['request'];
    }
}
