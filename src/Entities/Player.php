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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getHand()
    {
        return $this->hand;
    }

    /**
     * @param CardInterface $card
     * @return CardInterface|null
     */
    public function playCard(CardInterface $card): ?CardInterface
    {
        $playedCard = $this->playCardByRank($card->getRank());
        if (!$playedCard) {
            $playedCard = $this->playCardBySuite($card->getSuite());
        }

        return $playedCard;
    }

    /**
     * @param $suite
     * @return CardInterface|null
     */
    public function playCardBySuite($suite): ?CardInterface
    {
        foreach ($this->hand as $key => $card) {
            if ($card->isEqualWithSuite($suite)) {
                unset($this->hand[$key]);
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
        foreach ($this->hand as $key => $card) {
            if ($card->isEqualWithRank($rank)) {
                unset($this->hand[$key]);
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

    public function getValueOfHand(): int
    {
        $totalValueOfCards = 0;
        foreach ($this->hand as $card) {
            $totalValueOfCards += $card->getValue();
        }

        return $totalValueOfCards;
    }

    /**
     * @return int|void
     */
    public function getCardsNumberInHand(): int
    {
        return count($this->hand);
    }
}
