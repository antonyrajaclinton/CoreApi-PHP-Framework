<?php
namespace Root\Base\Handlers;

class Response
{
    public static function JSON(array $response = [], int $statusCode = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        die(json_encode([
            'status' => true,
            'message' => 'Success',
            'data' => null,
            ...$response
        ]));
    }
}
