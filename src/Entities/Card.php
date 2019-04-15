<?php


namespace App\Entities;

use App\Interfaces\CardInterface;

class Card implements CardInterface
{
    // I added the numbers as string on purpose for all the values
    // to have the same type and the keys represent the value of the card
    const RANKS = [
        1 => 'A', 2 => '2', 3 => '3', 4 => '4',
        5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9',
        10 => '10', 12 => 'J', 13 => 'Q', 14 => 'K'
    ];
    const SUITES = ['Hearts', 'Spades', 'Clubs', 'Diamonds'];

    private $rank;
    private $suite;
    private $value;

    public function __construct(string $rank, string $suite)
    {
        $this->setRank($rank);
        $this->setSuite($suite);

        // $rank should always be in the RANKS array because otherwise the
        // setRank() method would throw an error
        $this->setValue(array_search($rank, self::RANKS));

    }

    public function getRank()
    {
        return $this->rank;
    }

    public function getSuite()
    {
        return $this->suite;
    }

    public function getValue()
    {
        return $this->value;
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

    public function setValue(int $value)
    {
        $this->value = $value;
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
