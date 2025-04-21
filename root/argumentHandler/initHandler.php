<?php

namespace Root\ArgumentHandler;

class InitArgument
{
    private $arg = [];
    private $argMain = '';
    private $arg1 = null;
    private $arg2 = null;
    private $arg3 = null;
    private $arg4 = null;
    public function __construct($arguments = [])
    {
        $this->argMain = (!empty($arguments[0])) ? strtolower(trim($arguments[0])) : '';
        if (!isset($arguments[1]) || !isset($arguments[0])) {
            $message = "no argument found..! \n\n";
            $message .= "Available Arguments: \n";
            $message .= "php server : php {$this->argMain} serve\n";

            die($message);
        }
        $this->arg = $arguments;
        $this->arg1 = (!empty($arguments[1])) ? strtolower(trim($arguments[1])) : null;
        $this->arg2 = (!empty($arguments[2])) ? strtolower(trim($arguments[2])) : null;
        $this->arg3 = (!empty($arguments[3])) ? strtolower(trim($arguments[3])) : null;
        $this->arg4 = (!empty($arguments[4])) ? strtolower(trim($arguments[4])) : null;
    }

    public function init()
    {
        if ($this->arg1 == 'serve') {
            $this->serve();
        }
    }
    public function getOptions(): array
    {
        $options = [];
        foreach ($this->arg as $argument) {
            if (str_contains($argument, '--')) {
                $splitValues = explode('=', $argument);
                $options[trim(strtolower($splitValues[0]), '-')] = (isset($splitValues[1])) ? $splitValues[1] : null;
            }
        }
        return $options;
    }

    private function serve()
    {
        $getOptions = $this->getOptions();
        $host = (!empty($getOptions['host'])) ? $getOptions['host'] : 'localhost';
        $port = (!empty($getOptions['port'])) ? $getOptions['port'] : '8000';
        echo "🚀 Starting development server at http://{$host}:{$port}\n";
        echo "🔧 To use a different host/port: php {$this->argMain} serve --host={$host} --port={$port}\n";
        echo "🛑 Press Ctrl+C to stop\n";

        passthru("php -S {$host}:{$port} index.php");
    }
}
