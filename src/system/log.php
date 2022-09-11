<?php

declare(strict_types=1);

namespace system;

class log
{
	private $_model = null;

	public function __construct(array $db_config)
	{
		$this->_model = new log\model($db_config);
	}

	public function start(
		object $user,
		object $request
	): void {

		$user_id = $user->id();

		$this->_model->start($user_id, $request);
	}

	public function stop(
		object $response
	): void {

		$this->_model->stop($response);
	}
}
