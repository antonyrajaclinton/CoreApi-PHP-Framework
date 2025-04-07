<?php

use System\Core\Handlers\Response;
use System\Core\Handlers\Logger;

class ErrorHandler
{
    public function handleException(array $getError): void
    {
        $error = [
            'date' => gmdate('Y-m-d H:i:s'),
            'level' => $getError['level'] ?? 0,
            'message' => $getError['message'] ?? 'Unknown error',
            'file' => $getError['file'] ?? 'Unknown file',
            'line' => $getError['line'] ?? 0
        ];
        Logger::error(json_encode($error));
        unset($error['date']);
        unset($error['level']);
        if (!in_array(env('APP_ENVIRONMENT'), ['development', 'dev', 'testing', ''])) {
            unset($error['file']);
            unset($error['line']);
        }

        Response::JSON([
            'status' => false,
            'message' => 'An error occurred. Please try again later.',
            'data' => null,
            'error' => $error
        ], 500);
    }
}
