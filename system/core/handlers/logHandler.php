<?php

namespace System\Core\Handlers;

use System\Core\Utilities;

class Logger
{
    private static function getLoggerConfig(): array
    {
        return [
            'log_path' => env('LOG_PATH', 'logs'),
            'log_file_extension' => env('LOG_FILE_EXTENSION', 'log'),
            'log_file_date' => gmdate(env('LOG_FILE_DATE_FORMAT', 'Y_m_d'))
        ];
    }
    private static function logWriter($loggerMessage, $filePath): void
    {
        $getEnabledLoggers =  str_replace(" ", "", env('LOGGER_ENABLED'));
        if (in_array($filePath, explode(',', $getEnabledLoggers))) {
            $getLoggerConfig = self::getLoggerConfig();
            $getLoggerFullPath = APP_PATH . '/' . $getLoggerConfig['log_path'] . '/' . $filePath;
            $loggerMessage = is_array($loggerMessage) ? json_encode($loggerMessage) : $loggerMessage;
            $loggerFileName = "log_{$getLoggerConfig['log_file_date']}.{$getLoggerConfig['log_file_extension']}";

            Utilities::makeDirectoryIfNotExists($getLoggerFullPath);
            $appendCommaIfErrorLog = ($filePath === 'error') ? ',' : '';
            error_log($loggerMessage . "{$appendCommaIfErrorLog}\n", 3, "{$getLoggerFullPath}/{$loggerFileName}");
        }
    }
    public static function access($loggerMessage): void
    {
        self::logWriter($loggerMessage, 'access');
    }
    public static function http($loggerMessage): void
    {
        self::logWriter($loggerMessage, 'http');
    }
    public static function info($loggerMessage): void
    {
        self::logWriter($loggerMessage, 'info');
    }
    public static function warning($loggerMessage): void
    {
        self::logWriter($loggerMessage, 'warning');
    }
    public static function debug($loggerMessage): void
    {
        self::logWriter($loggerMessage, 'debug');
    }
    public static function error($loggerMessage): void
    {
        self::logWriter($loggerMessage, 'error');
    }
    public static function log($loggerMessage, $filePath = 'log'): void
    {
        self::logWriter($loggerMessage, $filePath);
    }
}
