<?php
define("APP_PATH", dirname(__FILE__));

if (preg_match('/\.env$/', $_SERVER["REQUEST_URI"])) {
    http_response_code(403);
    exit("Access denied.");
}

require './root/initializeModules.php';
