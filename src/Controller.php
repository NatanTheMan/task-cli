<?php

namespace TaskCli;

use Exception;

class Controller
{
    private $args;
    private $argsCount;
    public $list = [];
    public $model;
    public $view;

    public function __construct(array $args, int $argsCount)
    {
        $this->args = $args;
        $this->argsCount = $argsCount;
        $this->model = new Model();
        $this->view = new View();
    }

    public function execute()
    {
        if ($this->argsCount == 1) {
            $this->help();
            return;
        }

        match(strtolower($this->args[1])) {
            "add" => $this->add(),
            "list" => $this->list(),
            "delete" => $this->delete(),
            "update" => $this->update(),
            "mark-done" => $this->setStatus(Status::Done),
            "mark-in-progress" => $this->setStatus(Status::InProgress),
            "help" => $this->help(),
            default => $this->help(),
        };
    }

    private function add()
    {
        $this->validateArgsCount(2, "No task description proved");

        $task = new Task($this->args[2]);
        $this->model->save($task);
    }

    private function list()
    {
        $tasks = [];
        if ($this->argsCount == 3) {
            $status = Status::tryFrom(strtolower($this->args[2]));
            if ($status == null) {
                throw new Exception("Invalid status");
            }
            $tasks = $this->model->listByStatus($status);
        } else {
            $tasks = $this->model->listAll();
        }

        $this->view->listAll($tasks);
    }

    public function delete()
    {
        $this->validateArgsCount(2, "Pass the ID of Task to delete");

        $id = intval($this->args[2]);
        if (!is_int($id)) {
            throw new Exception("ID need to be an integer number");
        }

        $this->model->delete($id);
    }

    public function update()
    {
        $this->validateArgsCount(2, "Pass the ID of Task to Update");
        $this->validateArgsCount(3, "Pass new description to Task");

        $id = intval($this->args[2]);
        $newDescription = strval(trim($this->args[3]));
        $this->model->update($id, $newDescription);
    }

    public function setStatus(Status $status)
    {
        $this->validateArgsCount(2, "Pass the ID of Task to set her Status");

        $id = intval($this->args[2]);
        $this->model->setStatus($id, $status);
    }

    private function validateArgsCount(int $index, string $messge)
    {
        if ($this->argsCount <= $index) {
            throw new Exception($messge);
        }
    }

    public function help()
    {
        $help = <<<TEXT
             ./index.php <action> <option>

             actions:
                 add <description>         - storage new task
                 list                      - print all tasks
                 list <status>             - print tasks that match with proved status
                 delete <id>               - delete task
                 update <id> <description> - update task description
                 mark-done <id>            - mark task as done
                 mark-in-progress <id>     - mark task as in-progress

            options:
                <id>         - int or string (7 or "9")
                <decription> - string ("Study math")
                <status>     - symbol or string (todo, in-progress or done)

            For more information check: https://github.com/NatanTheMan/task-cli
            TEXT;
        $this->view->help($help);
    }
}
