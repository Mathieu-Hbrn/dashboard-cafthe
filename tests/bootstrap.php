<?php
require_once __DIR__ . '/../vendor/autoload.php';

$config = require_once __DIR__ . '/../config.php';

define('DB_HOST', $config['local']['host']);
define('DB_NAME', $config['local']['db']);
define('DB_USER', $config['local']['user']);
define('DB_PASS', $config['local']['pass']);