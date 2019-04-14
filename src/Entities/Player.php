<?php


namespace App\Entities;

use App\Interfaces\CardInterface;
use App\Interfaces\PlayerInterface;

class Player implements PlayerInterface
{
    private $name;
    private $hand = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param CardInterface $card
     * @return CardInterface|null
     */
    public function playCard(CardInterface $card): ?CardInterface
    {
        $card = $this->playCardByRank($card->getRank());
        if (!$card) {
            $card = $this->playCardBySuite($card->getSuite());
        }

        return $card;
    }

    /**
     * @param $suite
     * @return CardInterface|null
     */
    public function playCardBySuite($suite): ?CardInterface
    {
        foreach ($this->hand as $card) {
            if ($card->isEqualWithSuite($suite)) {
                return $card;
            }
        }

        return null;
    }

    /**
     * @param $rank
     * @return CardInterface|null
     */
    public function playCardByRank($rank): ?CardInterface
    {
        foreach ($this->hand as $card) {
            if ($card->isEqualWithRank($rank)) {
                return $card;
            }
        }

        return null;
    }

    /**
     * Add a new card to hand
     *
     * @param CardInterface $card
     */
    public function drawCard(CardInterface $card)
    {
        array_push($this->hand, $card);
    }
}
