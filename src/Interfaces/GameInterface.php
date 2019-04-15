<?php

namespace App\Interfaces;

interface GameInterface
{
    public function initiateGame();

    // These are different per type of game. While Crazy Eights can
    // have 6 as initial cards per player, another game can have less
    public function findStartingPlayer();
    public function getNumberOfPlayers();
    public function getInitialCardsPerPlayer();
    public function playHand(CardInterface $lastCard);
    public function assertWinner(PlayerInterface $player);
}
