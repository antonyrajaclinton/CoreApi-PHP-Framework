<?php

namespace Root\Base\Handlers;

class Request
{
    public static function input($getKey = null, $optionalValue = null): mixed
    {
        if ($getKey) {
            $getRequest = self::request($getKey);
            if ($getRequest) {
                return $getRequest ?? $optionalValue;
            } else {
                return self::json($getKey) ?? $optionalValue;
            }
        } else {
            $getJsonValues = self::json($getKey) ?? [];
            return [...self::request(), ...$getJsonValues];
        }
    }
    public static function get($key = null, $optionalValue = null): mixed
    {
        if ($key) {
            return $_GET[$key] ?? $optionalValue;
        } else {
            return $_GET;
        }
    }
    public static function post($key = null, $optionalValue = null): mixed
    {
        if ($key) {
            return $_POST[$key] ?? $optionalValue;
        } else {
            return $_POST;
        }
    }
    public static function request($key = null, $optionalValue = null): mixed
    {
        if ($key) {
            return $_REQUEST[$key] ?? $optionalValue;
        } else {
            return $_REQUEST;
        }
    }
    public static function json($key = null, $optionalValue = null): mixed
    {
        $json = json_decode(file_get_contents('php://input'), true);
        if ($key) {
            return $json[$key] ?? $optionalValue;
        } else {
            return $json;
        }
    }
    public static function raw(): mixed
    {
        $raw = file_get_contents('php://input');
        return $raw ?? null;
    }
    public static function file($key = null, $optionalValue = null): mixed
    {
        if ($key) {
            return $_FILES[$key] ?? $optionalValue;
        } else {
            return $_FILES;
        }
    }
    public static function cookie($key = null, $optionalValue = null): mixed
    {
        if ($key) {
            return $_COOKIE[$key] ?? $optionalValue;
        } else {
            return $_COOKIE;
        }
    }
    public static function session($key = null, $optionalValue = null): mixed
    {
        if ($key) {
            return $_SESSION[$key] ?? $optionalValue;
        } else {
            return $_SESSION;
        }
    }
    public static function header($key = null, $optionalValue = null): mixed
    {
        if ($key) {
            return getallheaders()[$key] ?? $optionalValue;
        } else {
            return getallheaders();
        }
    }
    public static function server($key = null, $optionalValue = null): mixed
    {
        if ($key) {
            return $_SERVER[$key] ?? $optionalValue;
        } else {
            return $_SERVER;
        }
    }
    public static function uri(): string
    {
        return $_SERVER['REQUEST_URI'] ?? '/';
    }
    public static function all(): array
    {
        return $_REQUEST;
    }
    public static function method(): string | null
    {
        return $_SERVER['REQUEST_METHOD'] ?? null;
    }
    public static function baseUrl(): string
    {
        return isset($_SERVER['HTTPS']) ? 'https://' : 'http://' . $_SERVER['HTTP_HOST'];
    }
    public static function isHttps(): bool
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
    }
    public static function ipAddress(): mixed
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return isset($ips[0]) ? trim($ips[0]) : null;
        }
        return $_SERVER['REMOTE_ADDR'] ?? null;
    }
    public static function bearerToken(): string | null
    {
        $authHeader = self::header('Authorization');
        if ($authHeader) {
            $token = preg_replace('/^Bearer\s+/i', '', $authHeader);
            if ($token) {
                return $token;
            }
        }
        return null;
    }
}
