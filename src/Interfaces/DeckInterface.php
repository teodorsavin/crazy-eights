<?php

namespace App\Interfaces;

interface DeckInterface
{
    // this might make sense to be private
    public function init();

    public function shuffle();
    public function drawFromDeck(): CardInterface;
    public function hasCards(): int;
}
