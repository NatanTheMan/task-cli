<?php

namespace TaskCli;

class Task
{
    public $description;

    public function __construct(string $description)
    {
        $this->description = $description;
    }
}
