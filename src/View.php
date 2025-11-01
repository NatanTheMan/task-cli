<?php

namespace TaskCli;

use Exception;

class View
{
    public function exception(Exception $e)
    {
        echo $e->getMessage(), PHP_EOL;
    }

    public function listAll(array $tasks)
    {
        foreach ($tasks as $task) {
            echo $task->description, PHP_EOL;
        }
    }
}
