<?php

namespace Root\Base;
class Utilities
{
    static function makeDirectoryIfNotExists($dir): void
    {
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }
    public static function uuid(): string
    {
           return hash('md5', bin2hex(random_bytes(10). base64_encode(microtime(true))));    
    }
}
