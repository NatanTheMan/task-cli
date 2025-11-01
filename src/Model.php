<?php

namespace TaskCli;

class Model
{
    private $filePath;

    public function __construct()
    {
        $this->filePath = dirname(__FILE__, 2) . "/database.json";
        if (!file_exists($this->filePath)) {
            $file = fopen($this->filePath, "w");
            fwrite($file, "[]");
            fclose($file);
        }
    }

    public function save(Task $task): void
    {
        $array = json_decode(file_get_contents($this->filePath));
        array_push($array, $task);
        $file = fopen($this->filePath, "w");
        fwrite($file, json_encode($array));
        fclose($file);
    }

    /**
     * @return array<Task>
     */
    public function listAll(): array
    {
        return json_decode(file_get_contents($this->filePath));
    }

    public function delete(int $id): void
    {
        $tasks = json_decode(file_get_contents($this->filePath));
        unset($tasks[$id - 1]);
        $file = fopen($this->filePath, "w");
        fwrite($file, json_encode($tasks));
        fclose($file);
    }
}
