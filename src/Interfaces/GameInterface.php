<?php

namespace App\Interfaces;

interface GameInterface
{
    public function initiateGame();
    public function findStartingPlayer();
    public function getNumberOfPlayers();
    public function getInitialCardsPerPlayers();
}
