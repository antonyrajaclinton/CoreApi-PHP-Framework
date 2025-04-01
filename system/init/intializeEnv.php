<?php

function loadEnv($filePath)
{
    if (!file_exists($filePath)) {
        throw new Exception("{$filePath} file not found");
    }
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue; // Skip comments
        putenv($line);
        list($key, $value) = explode('=', $line, 2);
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

// Load the .env file
$getEnvironmentVaraible = getenv('APP_ENVIRONMENT');
if ($getEnvironmentVaraible && !empty($getEnvironmentVaraible)) {
    loadEnv(APP_PATH . "/.env.{$getEnvironmentVaraible}");
} else {
    loadEnv(APP_PATH . "/.env");
}


function env($key, $defaultValue)
{
    if ($key && getenv($key)) {
        $returnValue = getenv($key);
    } else {
        $returnValue = $defaultValue;
    }
    return  $returnValue;
}
