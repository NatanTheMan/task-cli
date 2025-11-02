<?php

namespace TaskCli;

use Exception;

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
        $tasks = $this->decode();
        array_push($tasks, $task);
        $this->write(json_encode($tasks));
    }

    /**
     * @return array<Task>
     */
    public function listAll(): array
    {
        return $this->decode();
    }

    public function listByStatus(Status $status): array
    {
        $tasks = $this->decode();
        return array_filter(
            $tasks,
            function ($task) use ($status) {
                return Status::from($task->status) == $status;
            }
        );
    }

    public function delete(int $id): void
    {
        $tasks = $this->decode();
        unset($tasks[$id - 1]);
        $this->write(json_encode($tasks));
    }

    public function update(int $id, string $newDesc): void
    {
        $tasks = $this->decode();
        if (!array_key_exists($id - 1, $tasks)) {
            throw new Exception("Not found task with id: $id");
        }
        $tasks[$id - 1]->description = $newDesc;
        $this->write(json_encode($tasks));
    }

    public function setStatus(int $id, Status $status)
    {
        $tasks = $this->decode();
        if (!array_key_exists($id - 1, $tasks)) {
            throw new Exception("Not found task with id: $id");
        }
        $tasks[$id - 1]->status = $status;
        $this->write(json_encode($tasks));
    }

    private function write(string $content)
    {
        $file = fopen($this->filePath, "w");
        fwrite($file, $content);
        fclose($file);
    }

    /**
     * @return array<Task>
     */
    private function decode(): array
    {
        return json_decode(file_get_contents($this->filePath)) ;
    }
}
