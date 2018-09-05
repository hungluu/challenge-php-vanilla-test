<?php
// Debug on
ini_set( 'display_errors', 1 );
ini_set( 'error_reporting', E_ALL );

// Init composer autoloader
require "../vendor/autoload.php";

// Load dot env config
// $dotenv = new Dotenv\Dotenv(__DIR__ . '/config');
// $dotenv->load();

echo json_encode($_REQUEST);
