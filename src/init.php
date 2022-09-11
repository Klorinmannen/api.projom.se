<?php

declare(strict_types=1);

require_once('auto_loader.php');

// Start session after auto_loader
session_start();

$interfaces = new interfaces();
$http = new http();
$system = new system();
