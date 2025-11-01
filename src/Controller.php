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
            throw new Exception("No arguments passed");
        }

        match($this->args[1]) {
            "add" => $this->add(),
            "list" => $this->list(),
            "delete" => $this->delete(),
            "update" => $this->update(),
        };
    }

    private function add()
    {
        if ($this->argsCount <= 2) {
            throw new Exception("No task description proved");
        }

        $task = new Task($this->args[2]);
        $this->model->save($task);
    }

    private function list()
    {
        $tasks = $this->model->listAll();
        $this->view->listAll($tasks);
    }

    public function delete()
    {
        if ($this->argsCount <= 2) {
            throw new Exception("Pass the ID of Task to delete");
        }
        $id = intval($this->args[2]);
        if (!is_int($id)) {
            throw new Exception("ID need to be an integer number");
        }

        $this->model->delete($id);
    }

    public function update()
    {
        if ($this->argsCount <= 2) {
            throw new Exception("Pass the ID of Task to Update");
        }
        if ($this->argsCount <= 3) {
            throw new Exception("Pass new description to Task");
        }

        $id = intval($this->args[2]);
        $newDescription = strval(trim($this->args[3]));
        $this->model->update($id, $newDescription);
    }
}
