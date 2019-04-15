<?php


namespace App\Loggers;


use App\Interfaces\LoggerInterface;

class Logger implements LoggerInterface
{
    public function log(string $message)
    {
        echo $message;
        echo "\n";
    }
}
