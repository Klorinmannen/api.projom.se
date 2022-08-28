<?php

declare(strict_types=1);

namespace api;

class request extends \http\request
{
    public function __construct()
    {
        parent::__construct();
    }

    public function url_path(): string
    {
        return '/'.$this->_url_path;
    }
}
