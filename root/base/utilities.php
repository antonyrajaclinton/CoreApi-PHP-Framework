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
}
