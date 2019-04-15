<?php


namespace App;

use App\Entities\Game;
use App\Interfaces\CardInterface;
use App\Interfaces\DeckInterface;
use App\Interfaces\LoggerInterface;
use App\Interfaces\PlayerInterface;

class CrazyEights extends Game
{
    protected $numberOfPlayers;
    protected $startingPlayerIndex;
    protected $discardedPile;
    protected $lastCardPlayed;

    const MAX_NUMBER_OF_PLAYERS = 6;
    const INITIAL_CARDS_PER_PLAYER = 5;

    public function __construct(DeckInterface $deck, LoggerInterface $logger, int $numberOfPlayers)
    {
        parent::__construct($deck, $logger);

        $this->setNumberOfPlayers($numberOfPlayers);
        $this->lastCardPlayed = $this->deck->drawFromDeck();
    }

    /**
     * @return int
     */
    public function getNumberOfPlayers(): int
    {
        return $this->numberOfPlayers;
    }

    /**
     * @param $numberOfPlayers
     * @throws \Exception
     */
    public function setNumberOfPlayers($numberOfPlayers): void
    {
        if (self::MAX_NUMBER_OF_PLAYERS < $numberOfPlayers) {
            throw new \Exception('Maximum number of players is ' . self::MAX_NUMBER_OF_PLAYERS);
        }

        $this->numberOfPlayers = $numberOfPlayers;
    }

    /**
     * @return int
     */
    public function getInitialCardsPerPlayer(): int
    {
        return self::INITIAL_CARDS_PER_PLAYER;
    }

    /**
     * @return int
     */
    public function getMaxNumberOfPlayers(): int
    {
        return self::MAX_NUMBER_OF_PLAYERS;
    }

    /**
     * Find the first player with the most hand value and set it as a starting player
     *
     * @return int
     */
    public function findStartingPlayer(): int
    {
        $maxValue = 0;
        $this->startingPlayerIndex = null;
        foreach ($this->players as $key => $player) {
            $currentPlayerHandValue = $player->getValueOfHand();

            if ($maxValue < $currentPlayerHandValue) {
                $maxValue = $currentPlayerHandValue;
                $this->startingPlayerIndex = $key;
            }
        }

        return $this->startingPlayerIndex;
    }

    /**
     * @param CardInterface $lastCard
     */
    public function playHand(CardInterface $lastCard)
    {
        $this->lastCardPlayed = $lastCard;
    }

    public function play()
    {
        $noWinner = true;
        $currentPlayerIndex = $this->findStartingPlayer();
        while ($noWinner) {

            /** @var PlayerInterface $currentPlayer */
            $currentPlayer = $this->players[$currentPlayerIndex];

            $this->logger->log("Now it's {$currentPlayer->getName()} turn!");

            // check if player has card in hand to play based on lastCardPlayed
            $cardPlayed = $currentPlayer->playCard($this->lastCardPlayed);

            if ($cardPlayed !== null) {
                // Player had a card to be played
                $this->lastCardPlayed = $cardPlayed;

                if ($this->assertWinner($currentPlayer)) {
                    $this->logger->log($currentPlayer->getName() . ' is the WINNER!');
                    return $currentPlayer;
                }
            } else {
                // Player didn't have a card in his hand to play
                if ($this->deck->hasCards() > 0) {
                    $newCard = $this->deck->drawFromDeck();
                    $currentPlayer->drawCard($newCard);

                    $this->logger->log("{$currentPlayer->getName()} draw a {$newCard->getRank()} of {$newCard->getSuite()} from the deck.");
                } else {
                    // skip
                    $this->logger->log("{$currentPlayer->getName()} skipped because there are no cards in the deck");
                }
            }

            // change player to the next one. If it is the last player, start over from 0
            $currentPlayerIndex = (++$currentPlayerIndex) % $this->numberOfPlayers;
        }

    }

    public function assertWinner(PlayerInterface $player)
    {
        return (bool) !$player->getCardsNumberInHand();
    }
}
