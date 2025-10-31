<?php

namespace TaskCli;

use Exception;

class Controller
{
    private $args;
    private $argsCount;

    public function __construct(array $args, int $argsCount)
    {
        $this->args = $args;
        $this->argsCount = $argsCount;
    }

    public function execute()
    {
        if ($this->argsCount == 1) {
            throw new Exception("No arguments passed");
        }

        match($this->args[1]) {
            "add" => $this->add()
        };
    }

    private function add()
    {
        if ($this->argsCount <= 2) {
            throw new Exception("No task description proved");
        }
    }
}
