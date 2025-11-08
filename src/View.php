<?php

namespace TaskCli;

use Exception;

class View
{
    public function exception(Exception $e)
    {
        echo $e->getMessage(), PHP_EOL;
    }

    public function listAll(array $tasks): void
    {
        echo "ID - DESCRIPTION - STATUS", PHP_EOL, PHP_EOL;
        foreach ($tasks as $task) {
            echo "$task->id - $task->description - $task->name",  PHP_EOL;
        }
    }

    public function help(string $content)
    {
        echo $content, PHP_EOL;
    }
}
