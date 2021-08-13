<?php

namespace App\Models;

class GameBoard
{

    const DeckCount = 6;
    public $stack;

    public function __construct()
    {
        $this->stack = self::createStack();
    }

    private static function createStack(){
        $deck = Deck::createDeck();
        $stack = [];
        for($i=1;$i<=self::DeckCount;$i++){
            foreach ($deck as $card){
                $stack[] = $card;
            }
        }
        return $stack;
    }

    public function pullCard()
    {
        $key = array_rand($this->stack);
        $card = $this->stack[$key];
        unset($this->stack[$key]);

        return $card;
    }

}