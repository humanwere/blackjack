<?php

namespace App\Models;

class GameBoard
{

    const DeckCount = 6;
    protected $stack;
    protected $dealerHand;
    protected $playerHand;

    public function __construct($stack=null)
    {
        if($this->stack===null & $stack===null){
            $this->stack = $_SESSION['stack'] = $this->getStack();
        }else{
            $this->stack = $stack;
        }
    }

    private static function createStack(){
        $deck = Deck::createDeck();

        $stack = [];
        for($i=1;$i<=self::DeckCount;$i++){
            foreach ($deck as $card){
                $stack[] = $card;
            }
        }
        shuffle($stack);
        return $stack;
    }

    public function pullCard()
    {
        $stack = $this->getStack();

        $card = $stack[array_key_first($stack)];
        unset($stack[array_key_first($stack)]);
        $this->setStack($stack);
        return $card;
    }

    public function getStack()
    {
        if($this->stack==null){
           $this->setStack(self::createStack());
        }
        return $this->stack;
    }

    public function setStack($stack)
    {
        $this->stack = $stack;
        $_SESSION['stack'] = $stack;
    }

}