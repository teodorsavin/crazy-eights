<?php

namespace App\Interfaces;

interface LoggerInterface
{
    public function log(string $message);
    public function logPlayerHand(PlayerInterface $player);
}
