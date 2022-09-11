<?php

declare(strict_types=1);

namespace http;

use http\input\validate;
use util\template;

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
        if ($method = validate::string_key($_SERVER, 'REQUEST_METHOD'))
            $this->_method = strtoupper($method);
        if ($url = validate::string_key($_SERVER, 'REQUEST_URI'))
            $this->_url = $url;

        self::parse_url();
        self::parse_headers();
        self::set_data();
        self::set_type_id();
        self::set_url_path_parts();
    }

    private function parse_url(): void
    {
        $this->_parsed_url = parse_url($this->_url);
        if ($query = validate::query_key($this->_parsed_url, 'query'))
            parse_str($query, $this->_query_params);
        if ($path = validate::query_key($this->_parsed_url, 'path'))
            $this->_url_path = ltrim($path, '/');
        if ($hostname = validate::query_key($this->_parsed_url, 'host'))
            $this->_hostname = trim($hostname);
    }

    private function parse_headers(): void
    {
        if ($auth_header = validate::string_key($_SERVER, 'HTTP_AUTHORIZATION'))
            if (input\strings::match_pattern($auth_header, '/^Bearer .+/'))
                $this->_auth_header = trim(str_replace('Bearer', '', $auth_header));
    }

    private function set_data(): void
    {
        switch ($this->_method) {
            case 'POST':
            case 'PUT':
            case 'PATCH':
                $this->_input_data = file_get_contents('php://input') ?? '';

                break;
            default:
                $this->_input_data = '';
                break;
        }
    }

    private function set_type_id(): void
    {
        if (input\strings::match_pattern($this->_url_path, self::DOCS_PATTERN))
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

    public function query_param(string $param): ?string
    {
        if (!$query_param = validate::string_key($this->_query_params, $param))
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

    public function auth_header(): string
    {
        return $this->_auth_header;
    }

    public function type_id(): int
    {
        return $this->_type_id;
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

    public function stringify(): string
    {
        $vars = [
            'method' => $this->_method,
            'url' => $this->_url
        ];
        $request_template = '{{method}}: {{url}}';
        return template::bind($request_template, $vars);
    }

    public function input_data(): string
    {
        return $this->_input_data;
    }

    public function redirect(
        string $place,
        int $code = 301
    ): void {
        
        $header = 'Location: ' . $place;
        header($header, true, $code);
        exit;

    }
}
