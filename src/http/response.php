<?php

declare(strict_types=1);

namespace http;

use http\input\validate;
use \util\json;
use \util\template;

class response
{

	private $_data = null;
	private $_formatted_data = null;
	private $_data_format = '';

	private $_header = '';
	private $_charset = '';
	private $_content_type = '';

	private $_code = 0;

	public function __construct(array $from_data = [])
	{
		$this->_charset = 'utf-8';
		$this->_code = 200;
		$this->_content_type = 'text/html';
		$this->_data_format = 'html';

		$this->set_from_data($from_data);
	}

	public function set_from_data(array $from_data): object
	{
		if (!$from_data)
			return $this;

		if ($charset = validate::string_key($from_data, 'charset'))
			$this->_charset = $charset;

		if ($content_type = validate::string_key($from_data, 'content_type'))
			$this->_content_type = $content_type;

		if ($data_format = validate::string_key($from_data, 'data_format'))
			$this->_data_format = $data_format;

		if ($code = validate::int_key($from_data, 'code'))
			$this->_code = $code;

		return $this;
	}

	public function set_code(int $code): object
	{
		$this->_code = $code;
		return $this;
	}

	public function set_header(string $header): object
	{
		$this->_header = $header;
		return $this;
	}

	public function set_content_type(string $content_type): object
	{
		$this->_content_type = $content_type;
		return $this;
	}

	public function set_charset(string $charset): object
	{
		$this->_charset = $charset;
		return $this;
	}

	public function send(): void
	{
		$this->_set_header();
		$this->_format_data();

		header($this->_header, true, $this->_code);
		echo $this->_formatted_data;

		exit;
	}

	private function _set_header(): void
	{
		if ($this->_header)
			return;

		$vars = [
			'content_type' => $this->_content_type,
			'charset' => $this->_charset
		];

		$header_template = 'Content-Type: {{content_type}}; Charset: {{charset}}';

		$this->_header = template::bind($header_template, $vars);
	}

	private function _format_data(): void
	{
		switch ($this->_data_format) {
			case 'html':
				$this->_formatted_data = $this->_data;
				break;
			case 'json':
				$this->_formatted_data = json::encode($this->_data);
				break;
			default:
				throw new \Exception('Unknown data format', 500);
		}
	}
}
