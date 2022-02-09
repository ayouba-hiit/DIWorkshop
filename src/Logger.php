<?php

namespace App;

class Logger
{
    public function log(string $message)
    {
        var_dump('Logger :'.$message);
    }
}