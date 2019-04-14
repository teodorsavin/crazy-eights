<?php

namespace App\Interfaces;


interface PlayerInterface
{
    public function playCard(CardInterface $card);
    public function playCardBySuite($suite);
    public function playCardByRank($rank);
    public function drawCard(CardInterface $card);
}
