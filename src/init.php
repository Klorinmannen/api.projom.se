<?php

declare(strict_types=1);

require_once('auto_loader.php');

if (\system::interface_id() != \interfaces::WEB_ID)
	return;

// Start session after auto_loader <--
session_start();

\system::init();
