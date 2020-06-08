<?php

// Start session
session_start();

require('dbconnect.php');

// Turn on/off error reporting
error_reporting(-1);

define('ROOT_PATH', '..' . __DIR__ . '/'); // path to 'my-page-3/'
define('SRC_PATH',  __DIR__ . '/'); // path to 'my-page-3/src/'

// Include functions and classes
