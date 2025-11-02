<?php

namespace TaskCli;

use Exception;

class View
{
    public function exception(Exception $e)
    {
        echo $e->getMessage(), PHP_EOL;
    }

    /**
     * @param array<Task> $task
     * @return void
     */
    public function listAll(array $tasks): void
    {
        foreach ($tasks as $i => $task) {
            echo $i + 1 . " - $task->description - " . $task->status,  PHP_EOL;
        }
    }
}
