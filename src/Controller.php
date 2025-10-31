<?php

namespace TaskCli;

class Controller
{
    private $argsCount;

    public function __construct(int $argsCount)
    {
        $this->argsCount = $argsCount;
    }

    public function execute()
    {
        if ($this->argsCount == 1) {
            die("No arguments passed");
        }
        echo "passed";
    }
}
