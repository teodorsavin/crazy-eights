<?php


namespace App\Entities;

use App\Interfaces\CardInterface;
use App\Interfaces\DeckInterface;

class Deck implements DeckInterface
{
    private $deck;

    public function __construct()
    {
        $this->init();
    }

    /**
     * Initiate deck of cards for a new game
     */
    public function init()
    {
        // reset deck to an empty array
        $this->deck = [];

        foreach (Card::SUITES as $suite) {
            foreach (Card::RANKS as $rank) {
                $this->deck[] = new Card($rank, $suite);
            }
        }
    }

    /**
     * Shuffle the deck of cards
     */
    public function shuffle(): void
    {
        shuffle($this->deck);
    }

    /**
     * return the last element of the deck
     *
     * @return CardInterface
     */
    public function drawFromDeck(): CardInterface
    {
        return array_pop($this->deck);
    }
}
