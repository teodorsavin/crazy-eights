<?php


namespace App\Loggers;

use App\Interfaces\LoggerInterface;
use App\Interfaces\PlayerInterface;

class Logger implements LoggerInterface
{
    public function log(string $message)
    {
        echo $message;
        echo "\n";
    }

    public function logPlayerHand(PlayerInterface $player)
    {
        $this->log("{$player->getName()} hand is: ");
        foreach ($player->getHand() as $card) {
            $this->log("{$card->getRank()} of {$card->getSuite()}");
        }
    }
}
