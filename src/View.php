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
        foreach ($tasks as $i => $task) {
            echo $i + 1 . " - $task->description", PHP_EOL;
        }
    }
}
