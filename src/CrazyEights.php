<?php


namespace App;

use App\Entities\Game;
use App\Interfaces\CardInterface;
use App\Interfaces\DeckInterface;
use App\Interfaces\PlayerInterface;

class CrazyEights extends Game
{
    protected $numberOfPlayers;
    protected $startingPlayerIndex;
    protected $discardedPile;
    protected $lastCardPlayed;

    const MAX_NUMBER_OF_PLAYERS = 6;
    const INITIAL_CARDS_PER_PLAYER = 5;

    public function __construct(DeckInterface $deck, int $numberOfPlayers)
    {
        parent::__construct($deck);

        $this->setNumberOfPlayers($numberOfPlayers);
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

    public function playHand(CardInterface $lastCard)
    {
        $this->lastCardPlayed = $lastCard;
    }

    public function play()
    {
        // TODO: Implement this method
    }
}
