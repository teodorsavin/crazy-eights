<?php

namespace App\Interfaces;

interface CardInterface
{
    public function getRank();
    public function getSuite();

    public function setRank(string $rank);
    public function setSuite(string $suite);

    public function isEqualWithRank(string $rank);
    public function isEqualWithSuite(string $suite);
}
