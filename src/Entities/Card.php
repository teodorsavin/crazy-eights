<?php


namespace App\Entities;

use App\Interfaces\CardInterface;

class Card implements CardInterface
{
    // I added the numbers as string on purpose for all the values to have the same type
    const RANKS = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
    const SUITES = ['Hearts', 'Spades', 'Clubs', 'Diamonds'];

    private $rank;
    private $suite;

    public function __construct(string $rank, string $suite)
    {
        $this->setRank($rank);
        $this->setSuite($suite);
    }

    public function getRank()
    {
        return $this->rank;
    }

    public function getSuite()
    {
        return $this->suite;
    }

    public function setRank(string $rank)
    {
        if (!in_array($rank, self::RANKS)) {
            throw new \Exception("{$rank} is not a valid rank");
        }

        $this->rank = $rank;
    }

    public function setSuite(string $suite)
    {
        if (!in_array($suite, self::SUITES)) {
            throw new \Exception("{$suite} is not a valid suite");
        }

        $this->suite = $suite;
    }

    /**
     * @param string $rank
     * @return bool
     */
    public function isEqualWithRank(string $rank)
    {
        return $this->getRank() === $rank;
    }

    /**
     * @param string $suite
     * @return bool
     */
    public function isEqualWithSuite(string $suite)
    {
        return $this->getSuite() === $suite;
    }
}
