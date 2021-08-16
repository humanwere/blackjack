<?php


namespace App\Models;

use App\Interfaces\Card as ICard;

class Card implements ICard
{
    private  $type;
    private $name;
    private $rank;

    public function __construct($type,$name,$rank)
    {
        $this->setType($type);
        $this->setName($name);
        $this->setRank($rank);
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * @param mixed $rank
     */
    public function setRank($rank): void
    {
        $this->rank = $rank;
    }



}