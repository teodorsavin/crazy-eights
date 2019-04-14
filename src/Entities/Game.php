<?php


namespace App\Entities;


use App\Interfaces\DeckInterface;
use App\Interfaces\GameInterface;

abstract class Game implements GameInterface
{
    private $deck;
    private $players;
    private $numberOfPlayers;
    private $initialCardsPerPlayer;

    public function __construct(DeckInterface $deck)
    {
        $this->deck = $deck;
        $this->numberOfPlayers = $this->getNumberOfPlayers();
        $this->initialCardsPerPlayer = $this->getInitialCardsPerPlayers();
    }

    public abstract function getNumberOfPlayers();
    public abstract function getInitialCardsPerPlayers();

    public function initiateGame()
    {
        $this->deck->shuffle();

        // add players to the table and give them cards
        for ($i = 1; $i <= $this->numberOfPlayers; $i++) {
            $player = new Player("Player {$i}");
            for ($j = 0; $j < $this->initialCardsPerPlayer; $j++) {
                $player->drawCard($this->deck->drawFromDeck());
            }
            $this->players[] = $player;
        }
    }

    public function findStartingPlayer()
    {
        // TODO: Implement findStartingPlayer() method.
    }
}
