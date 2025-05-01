<?php

namespace Root\Migration;

class MigrationSchema
{
    public static function column(string $name)
    {
        return new class($name) {
            private string $name;
            private string $type = 'TEXT';
            private bool $nullable = false;
            private bool $primary = false;
            private bool $unique = false;
            private bool $index = false;
            private bool $autoIncrement = false;

            public function __construct(string $name)
            {
                $this->name = $name;
            }

            // Type methods
            public function text()             { $this->type = 'TEXT'; return $this; }
            public function varchar(int $len = 255) { $this->type = "VARCHAR($len)"; return $this; }
            public function date()             { $this->type = 'DATE'; return $this; }
            public function datetime()         { $this->type = 'DATETIME'; return $this; }
            public function longText()         { $this->type = 'LONGTEXT'; return $this; }
            public function int(int $len = 10) { $this->type = "INT($len)"; return $this; }
            public function bigInt(int $len = 20) { $this->type = "BIGINT($len)"; return $this; }
            public function tinyInt(int $len = 3) { $this->type = "TINYINT($len)"; return $this; }
            public function boolean()          { $this->type = 'BOOLEAN'; return $this; }
            public function decimal(int $p = 10, int $s = 2) { $this->type = "DECIMAL($p, $s)"; return $this; }
            public function json()             { $this->type = 'JSON'; return $this; }

            // Constraint methods
            public function nullable()         { $this->nullable = true; return $this; }
            public function primary()          { $this->primary = true; return $this; }
            public function unique()           { $this->unique = true; return $this; }
            public function index()            { $this->index = true; return $this; }
            public function autoIncrement()    { $this->autoIncrement = true; return $this; }

            private function quote(string $value, string $db): string
            {
                return in_array($db, ['pgsql', 'sqlite']) ? "\"$value\"" : "`$value`";
            }

            public function toSQL(string $db = 'mysql'): string
            {
                $db = strtolower($db);
                $name = $this->quote($this->name, $db);
                $type = $this->type;

                // DB-specific type overrides
                if (str_starts_with($type, 'INT') || str_starts_with($type, 'TINYINT') || str_starts_with($type, 'BIGINT')) {
                    if ($db === 'pgsql' || $db === 'sqlite') $type = 'INTEGER';
                    elseif ($db === 'sqlserver') $type = 'INT';
                }

                if ($type === 'BOOLEAN') {
                    $type = $db === 'sqlite' ? 'INTEGER' : ($db === 'sqlserver' ? 'BIT' : 'BOOLEAN');
                }

                if ($type === 'JSON') {
                    $type = $db === 'pgsql' ? 'JSONB' : ($db === 'sqlite' ? 'TEXT' : 'JSON');
                }

                if ($type === 'DATETIME' && $db === 'pgsql') $type = 'TIMESTAMP';
                if ($type === 'LONGTEXT' && $db !== 'mysql') $type = 'TEXT';

                if ($this->autoIncrement) {
                    $type = match ($db) {
                        'pgsql'    => 'SERIAL',
                        'sqlite'   => 'INTEGER',
                        'sqlserver'=> 'INT IDENTITY(1,1)',
                        default    => $type . ' AUTO_INCREMENT'
                    };
                }

                $sql = "$name $type";
                $sql .= $this->nullable ? ' NULL' : (!$this->autoIncrement ? ' NOT NULL' : '');

                if ($this->primary && $db !== 'sqlite') $sql .= ' PRIMARY KEY';
                elseif ($this->unique) $sql .= ' UNIQUE';

                return $sql;
            }

            public function __toString(): string
            {
                return $this->toSQL();
            }
        };
    }

    public static function createTable(string $name, array $columns, string $db = 'mysql'): string
    {
        $defs = array_map(fn($col) => $col->toSQL($db), $columns);
        $body = implode(",\n", $defs);
        return "CREATE TABLE `" . $name . "` (\n$body\n);";
    }

    public static function alterTable(string $name, array $columns, string $db = 'mysql'): string
    {
        $defs = array_map(fn($col) => $col->toSQL($db), $columns);
        $body = implode(",\n", $defs);
        return "ALTER TABLE `" . $name . "`\nADD $body;";
    }

    public static function renameTable(string $from, string $to, string $db = 'mysql'): string
    {
        $db = strtolower($db);
        return match ($db) {
            'pgsql', 'sqlite' => "ALTER TABLE \"$from\" RENAME TO \"$to\";",
            'sqlserver'       => "EXEC sp_rename '$from', '$to';",
            default           => "RENAME TABLE `$from` TO `$to`;"
        };
    }
}
