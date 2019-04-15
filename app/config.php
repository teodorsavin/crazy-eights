<?php

use App\CrazyEights;
use App\Entities\Deck;
use App\Interfaces\DeckInterface;
use App\Interfaces\LoggerInterface;
use App\Loggers\Logger;

return [
    DeckInterface::class => DI\create(Deck::class),
    LoggerInterface::class => DI\create(Logger::class),
    'crazyEights' => \DI\autowire(CrazyEights::class)
        ->constructorParameter('numberOfPlayers', DI\get('numberOfPlayers')),
    'numberOfPlayers' => 6,
];

