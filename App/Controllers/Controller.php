<?php


namespace App\Controllers;

use App\Models\GameBoard;


class Controller
{
    public $stack;
    public $board;

    public function __construct()
    {
        $this->stack = isset($_SESSION['stack']) && count($_SESSION['stack'])>0 ? $_SESSION['stack'] :  null;
        $this->board = new GameBoard($this->stack);
    }
    public function indexAction()
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            if(!isset($_SESSION["game"])){
                $_SESSION["game"]=true;
                $this->board->newRound();
            }
        }
        $_SESSION['userHandTotal'] = GameBoard::calculateTotal($_SESSION['userHand']);
        $_SESSION['dealerHandTotal'] = GameBoard::calculateTotal($_SESSION['dealerHand']);
    }

    public static function logout()
    {
        session_destroy();
        session_unset();
        unset($_SESSION["game"]);
        header('Location: '.'/');
    }

    public function hitAction()
    {
        if($_SESSION["game"]) {
            $this->board->pullCard('user');
            $this->board->checkWinner('hit');
        }
        header('Location: '.'/');
    }

    public function newRound()
    {
        if($_SESSION["game"]){
            $this->board->newRound();
        }else{
            header('Location: '.'/');
        }
    }

    public function stayAction()
    {
        if($_SESSION["game"]) {
            $this->board->checkWinner('stay');
        }

    }

}