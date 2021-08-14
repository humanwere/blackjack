<?php

namespace App\Models;

class GameBoard
{

    const DeckCount = 6;
    const DealerMaXHit = 17;
    const BlackJack = 21;
    protected mixed $stack= null;
    protected mixed $dealerHand = null;
    protected mixed $userHand = null;

    public function __construct($stack=null)
    {
        if($this->stack===null & $stack===null){
            $this->stack = $_SESSION['stack'] = $this->getStack();
            $this->setDealerHand(null);
            $this->setUserHand(null);
            $_SESSION['userHand'] = $this->getUserHand();
            $_SESSION['dealerHand'] = $this->getDealerHand();
            $_SESSION['userWinCount'] = 0;
            $_SESSION['dealerWinCount'] = 0;
        }else{
            $this->stack = $stack;
        }
    }

    public function newRound()
    {
        $this->setDealerHand(null);
        $this->setUserHand(null);
        $_SESSION['round'] = true;
        $_SESSION['time'] = time();
        unset($_SESSION['message']);
        $this->pullCard('dealer');
        $this->pullCard('user');
        $this->pullCard('dealer');
        $this->pullCard('user');
        $this->checkWinner('new');
    }

    private function createStack(): array
    {
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

    public function pullCard($player)
    {
        $stack = $this->getStack();

        $card = $stack[array_key_first($stack)];
        unset($stack[array_key_first($stack)]);
        if($player=='user'){
            $_SESSION['userHand'][] = $card;
            $this->setUserHand($_SESSION['userHand']);
        }elseif($player=='dealer'){
            $_SESSION['dealerHand'][] = $card;
            $this->setDealerHand($_SESSION['dealerHand']);
        }
        $this->setStack($stack);
        return $card;
    }

    public static function calculateTotal($hand)
    {
        $total = 0;
        $aceCount = 0;
        foreach ($hand as $card){
            if($card['name']=='A'){
                $aceCount++;
            }
            $total += $card['rank'];
        }
        if($aceCount>0){
            for($i=1;$i<=$aceCount;$i++){
                if($total>self::BlackJack){
                    $total -=10;
                }
            }
        }
        return $total;
    }

    public function checkWinner($status):void
    {
        if($_SESSION['round']){
            $userHandTotal = self::calculateTotal($_SESSION['userHand']);
            $dealerHandTotal = self::calculateTotal( $_SESSION['dealerHand']);
            if($status=="new"){
                if($userHandTotal == self::BlackJack) {
                    $this->dealerEndGame();
                    $dealerHandTotal = self::calculateTotal( $_SESSION['dealerHand']);
                    $this->whoWins($dealerHandTotal, $userHandTotal,true);
                }
            }elseif ($status=="hit"){
                $total = self::calculateTotal($_SESSION['userHand']);
                if($total > self::BlackJack) {
                    self::finishGame('dealer','Player busts! <b>Dealer Wins!</b>',false);
                }elseif($total == self::BlackJack){
                    $this->dealerEndGame();
                    $dealerHandTotal = self::calculateTotal( $_SESSION['dealerHand']);
                    $this->whoWins($dealerHandTotal, $userHandTotal,true);
                }
            }elseif($status=="stay"){
                $this->dealerEndGame();
                $dealerHandTotal = self::calculateTotal( $_SESSION['dealerHand']);
                $this->whoWins($dealerHandTotal, $userHandTotal);
            }
        }
    }

    public function whoWins($dealer,$user,$blackJack = false)
    {
        if($dealer>self::BlackJack){
            self::finishGame('user','Dealer Busts!! <b>Player Wins!</b>',$blackJack);
        }elseif($user>self::BlackJack){
            self::finishGame('dealer','Player Busts!! <b>Dealer Wins!</b>',false);
        }elseif($dealer>$user){
            self::finishGame('dealer','<b>Dealer Wins!</b>',false);
        }elseif($dealer<$user){
            self::finishGame('user','<b>Player Wins!</b>',$blackJack);
        }elseif ($dealer==$user){
            self::finishGame('draw','<b>Draw!</b>',false);
        }

    }

    public function dealerEndGame()
    {
        $dealerHandTotal = self::calculateTotal($_SESSION['dealerHand']);
        while($dealerHandTotal<self::DealerMaXHit){
            $this->pullCard('dealer');
            $dealerHandTotal = self::calculateTotal($_SESSION['dealerHand']);
        }
    }

    public static function finishGame($winner,$message,$blackJack)
    {
        $_SESSION['message'] = $blackJack ? 'Winner Winner, Chicken Dinner! '. $message : $message;
        $_SESSION['message'] .= ' <br />Round Time : '.time() - $_SESSION['time'];
        $_SESSION['round'] = false;
        if($winner=='user'){
            $_SESSION['userWinCount'] +=1;
        }elseif($winner=="dealer"){
            $_SESSION['dealerWinCount'] +=1;
        }
    }
    
    /**
     * ##########################
     * #### GETTERS & SETTERS ###
     * ##########################
     */

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

    /**
     * @return mixed
     */
    public function getDealerHand(): mixed
    {
        return $this->dealerHand;
    }

    /**
     * @param mixed $dealerHand
     */
    public function setDealerHand(mixed $dealerHand): void
    {
        $this->dealerHand = $dealerHand;
        $_SESSION['dealerHand'] = $this->getDealerHand();
    }

    /**
     * @return mixed
     */
    public function getUserHand(): mixed
    {
        return $this->userHand;
    }

    /**
     * @param mixed|null $userHand
     */
    public function setUserHand(mixed $userHand): void
    {
        $this->userHand = $userHand;
        $_SESSION['userHand'] = $this->getUserHand();
    }
    
}