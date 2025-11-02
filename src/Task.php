<?php

namespace TaskCli;

class Task
{
    public $description;
    public $status;

    public function __construct(string $description, string $status = Status::Todo)
    {
        $this->description = $description;
        $this->status = $status;
    }
}
