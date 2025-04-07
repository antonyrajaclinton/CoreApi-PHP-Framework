<?php
require_once APP_PATH . '/app/config/errorHandler.php';

//exception handler:
function exception_handler_base(Throwable $exception)
{
    $errorHandler = new ErrorHandler();
    $errorHandler->handleException([
        'level' => $exception->getCode(),
        'message' => $exception->getMessage(),
        'file' => $exception->getFile(),
        'line' => $exception->getLine()
    ]);
}

function error_handler_base($level, $error, $file, $line)
{
 $errorHandler = new ErrorHandler();
    $errorHandler->handleException([
        'level' => $level,
        'message' => $error,
        'file' => $file,
        'line' => $line
    ]);
}






set_exception_handler('exception_handler_base');
set_error_handler('error_handler_base', E_ALL);
