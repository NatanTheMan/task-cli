<?php

namespace TaskCli;

class Task
{
    public $description;
    public $status;

    public function __construct(string $description)
    {
        $this->description = $description;
        $this->status = Status::Todo;
    }
}
