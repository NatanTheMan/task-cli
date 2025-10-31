<?php

namespace TaskCli;

use Exception;

class View
{
    public function exception(Exception $e)
    {
        echo $e->getMessage(), PHP_EOL;
    }
}
