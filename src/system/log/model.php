<?php

declare(strict_types=1);

namespace system\log;

use DateTime;

class model
{

	private $_table = null;
	private $_start_date_time = null;
	private $_log_id = 0;

	public function __construct(array $db_config)
	{
		$this->_table = new \util\table('SystemLog', $db_config);
	}

	public function start(
		int $user_id,
		object $request
	): void {

		$this->_start_date_time = new DateTime();

		$request = $request->stringify();
		$request_method = $request->method();
		$request_url = $request->url();
		$request_data = $request->input_data();
		$request_type_id = $request->type_id();

		$fields = [
			'UserID' => $user_id,
			'Request' => $request,
			'RequestMethod' => $request_method,
			'RequestURL' => $request_url,
			'RequestData' => $request_data,
			'RequestTypeID' => $request_type_id,
			'RequestStart' => $this->_start_date_time->format('Y-m-d H:i:s'),
			'RequestStartUnixTime' => $this->_start_date_time->format('u')
		];

		$this->_log_id = $this->_table->insert($fields)->query();
	}

	public function stop(
		object $response
	): void {

		if (!$this->_log_id > 0)
			throw new \Exception('SystemLog id is not an id', 500);

		$stop_date_time = new DateTime();
		$stop_ymd = $stop_date_time->format('Y-m-d H:i:s');
		$stop_unixtime = $stop_date_time->format('u');

		$diff_date_time = $stop_date_time->diff($this->_start_date_time);
		$request_ms = (float)($diff_date_time->format('%s') / 1000);

		$response_data = $response->formatted_data();
		$response_code = $response->code();

		$fields = [
			'SystemLogID' => $this->_log_id,
			'ResponseData' => $response_data,
			'ResponseCode' => $response_code,
			'RequestStop' => $stop_ymd,
			'RequestStopUnixTime' => $stop_unixtime,
			'RequestTimeMS' => $request_ms
		];

		$this->_table->update($fields)->query();
	}
}
