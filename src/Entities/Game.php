<?php


namespace App\Entities;

use App\Interfaces\CardInterface;
use App\Interfaces\DeckInterface;
use App\Interfaces\GameInterface;

abstract class Game implements GameInterface
{
    protected $deck;
    protected $players;
    protected $numberOfPlayers;
    protected $initialCardsPerPlayer;
    protected $lastCard;

    public function __construct(DeckInterface $deck)
    {
        $this->deck = $deck;
        $this->numberOfPlayers = $this->getNumberOfPlayers();
        $this->initialCardsPerPlayer = $this->getInitialCardsPerPlayer();

        $this->initiateGame();
    }

    abstract public function getNumberOfPlayers();
    abstract public function getInitialCardsPerPlayer();
    abstract public function findStartingPlayer();
    abstract public function playHand(CardInterface $lastCard);

    public function initiateGame(): void
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


}
