<?php

namespace App\Models;

use App\Models\Card;
class Deck {


    const DeckCount = 6;
    /** Card types for creating deck  */
    const CardTypes = ['Clubs','Diamonds','Hearts','Spades'];
    /** Card ranks and their values for the game  */
    const CardRanks = [
        '2'     => 2,
        '3'     => 3,
        '4'     => 4,
        '5'     => 5,
        '6'     => 6,
        '7'     => 7,
        '8'     => 8,
        '9'     => 9,
        '10'    => 10,
        'J'     => 10,
        'Q'     => 10,
        'K'     => 10,
        'A'     => 11,
    ];

    protected $stack;
    /**
     * Method will create a fresh deck
     *
     * @return array
     */
    public static function createDeck()
    {
        $deck = [];
        foreach (self::CardTypes as $type){
            foreach (self::CardRanks as $name=>$rank){
                $card = new Card($type,$name,$rank);
                $deck[] = $card;
            }
        }

        return $deck;
    }

    private function createStack(): array
    {
        $deck = self::createDeck();

        $stack = [];
        for($i=1;$i<=self::DeckCount;$i++){
            foreach ($deck as $card){
                $stack[] = $card;
            }
        }
        shuffle($stack);
        return $stack;
    }



    /**
     * @return mixed
     */
    public function getStack(): mixed
    {
        if($this->stack==null){
            $this->setStack($this->createStack());
        }
        return $this->stack;
    }

    /**
     * @param $stack
     * @return void
     */
    public function setStack($stack)
    {
        $this->stack = $stack;
        $_SESSION['stack'] = $stack;
    }


}