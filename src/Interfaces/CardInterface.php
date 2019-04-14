<?php

namespace App\Interfaces;


interface CardInterface
{
    public function getRank();
    public function getSuite();

    public function setRank();
    public function setSuite();
}
