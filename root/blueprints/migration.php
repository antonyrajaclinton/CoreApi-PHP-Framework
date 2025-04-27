<?php

namespace Root\Migration;

class MigrationBP
{
    public static function dataType()
    {
        return new class {
            public function text() { return 'TEXT'; }
            public function int() { return 'INT'; }
        };
    }
}

MigrationBP::dataType()->text();
 