<?php

declare(strict_types=1);

class http 
{
	private $_request = null;
	private $_response = null;

	public function __construct()
	{
		$this->_request = new \http\request();
		$this->_response = new \http\response();
	}

	public function request(): object
	{
		return $this->_request;
	}

	public function response(): object
	{
		return $this->_response;
	}
}
