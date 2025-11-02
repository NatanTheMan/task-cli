<?php

namespace TaskCli;

enum Status: string
{
    case Done = "done";
    case Todo = "todo";
    case InProgress = "in-progress";
}
