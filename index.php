<?php
// Init composer autoloader
require "vendor/autoload.php";

// Load dot env config
$dotenv = new Dotenv\Dotenv(__DIR__ . '/config');
$dotenv->load();