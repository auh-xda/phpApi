<?php

$config = require 'config.php';

define("DB_HOST", $config['host']);
define("DB_USER", $config['user']);
define("DB_PASS", $config['password']);
define("DB_NAME", $config['database']);
define("SHOULD_LOG", $config['shouldLog']);
define("LOGGABLE", $config['loggable']);

require_once 'vendor/autoload.php';
