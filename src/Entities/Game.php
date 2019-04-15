<?php


namespace App\Entities;

use App\Interfaces\CardInterface;
use App\Interfaces\DeckInterface;
use App\Interfaces\GameInterface;
use App\Interfaces\PlayerInterface;
use App\Interfaces\LoggerInterface;

abstract class Game implements GameInterface
{
    protected $deck;
    protected $logger;
    protected $players;
    protected $numberOfPlayers;
    protected $initialCardsPerPlayer;
    protected $lastCard;

    public function __construct(DeckInterface $deck, LoggerInterface $logger)
    {
        $this->deck = $deck;
        $this->logger = $logger;
        $this->numberOfPlayers = $this->getNumberOfPlayers();
        $this->initialCardsPerPlayer = $this->getInitialCardsPerPlayer();

        $this->initiateGame();
    }

    abstract public function getNumberOfPlayers();
    abstract public function getInitialCardsPerPlayer();
    abstract public function findStartingPlayer();
    abstract public function playHand(CardInterface $lastCard);
    abstract public function assertWinner(PlayerInterface $player);

    public function initiateGame(): void
    {
        $this->deck->shuffle();

        $this->logger->log(
            "A new game is starting. We have on the table {$this->numberOfPlayers} players. \n
Let's wish them good luck!"
        );

        // add players to the table and give them cards
        for ($i = 1; $i <= $this->numberOfPlayers; $i++) {
            $player = new Player("Player {$i}");
            for ($j = 0; $j < $this->initialCardsPerPlayer; $j++) {
                $player->drawCard($this->deck->drawFromDeck());
            }
            $this->players[] = $player;

            $this->logger->logPlayerHand($player);
        }


    }
}
