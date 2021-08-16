<?php


namespace App\Interfaces;


Interface Card
{
    public function setType($type);
    public function getType();
    public function setName($name);
    public function getName();
    public function setRank($rank);
    public function getRank();
}