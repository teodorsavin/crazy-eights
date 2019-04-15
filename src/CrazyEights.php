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
        $this->setNumberOfPlayers($numberOfPlayers);

        parent::__construct($deck, $logger);

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
    public function setNumberOfPlayers(int $numberOfPlayers): void
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

    public function play(): ?PlayerInterface
    {
        $skipped = 0;
        $currentPlayerIndex = $this->findStartingPlayer();
        while (true) {

            // if we did a round where every player was skipped we got into an impossible game
            if ($skipped == $this->numberOfPlayers) {
                $this->logger->log('No winners. We reached an impossible game.');
                return null;
            }

            /** @var PlayerInterface $currentPlayer */
            $currentPlayer = $this->players[$currentPlayerIndex];

            $this->logger->log("Now it's {$currentPlayer->getName()} turn!");

            // check if player has card in hand to play based on lastCardPlayed
            $cardPlayed = $currentPlayer->playCard($this->lastCardPlayed);

            if ($cardPlayed !== null) {
                // Player had a card to be played
                $this->lastCardPlayed = $cardPlayed;
                $skipped = 0;

                $this->logger->log(
                    "{$currentPlayer->getName()} played card {$cardPlayed->getRank()} of {$cardPlayed->getSuite()}!"
                );

                // if the player does not have any cards in his hand he is the winner
                if ($this->assertWinner($currentPlayer)) {
                    $this->logger->log($currentPlayer->getName() . ' is the WINNER!');
                    return $currentPlayer;
                }
            } else {
                // Player didn't have a card in his hand to play
                if ($this->deck->hasCards() > 0) {
                    $this->drawNewCard($currentPlayer);
                    $skipped = 0;
                } else {
                    // skip
                    $skipped++;
                    $this->logger->log("{$currentPlayer->getName()} skipped because there are no cards in the deck");
                }
            }

            // change player to the next one. If it is the last player, start over from 0
            $currentPlayerIndex = (++$currentPlayerIndex) % $this->numberOfPlayers;
        };
    }

    /**
     * @param PlayerInterface $currentPlayer
     */
    private function drawNewCard(PlayerInterface $currentPlayer)
    {
        $newCard = $this->deck->drawFromDeck();
        $currentPlayer->drawCard($newCard);

        $this->logger->log(
            "{$currentPlayer->getName()} draw a {$newCard->getRank()} of {$newCard->getSuite()} from the deck."
        );
    }

    /**
     * @param PlayerInterface $player
     * @return bool
     */
    public function assertWinner(PlayerInterface $player)
    {
        return (bool) !$player->getCardsNumberInHand();
    }
}
