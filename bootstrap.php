<?php

ini_set('error_reporting', 1);
ini_set('display_errors', 1);

$config = require 'config.php';

define("DB_HOST", $config['host']);
define("DB_USER", $config['user']);
define("DB_PASS", $config['password']);
define("DB_NAME", $config['database']);
define("SHOULD_LOG", $config['shouldLog']);
define("LOGGABLE", $config['loggable']);


@session_start();
@session_regenerate_id();

require_once 'vendor/autoload.php';
