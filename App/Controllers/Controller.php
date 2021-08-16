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
        if(isset($_SESSION["game"])) {
            $this->board = new GameBoard($_SESSION['playerName'], $_SESSION['delay']);
        }

    }
    public function indexAction()
    {
        if(isset($_SESSION["game"])) {
            $_SESSION['userHandTotal'] = GameBoard::calculateTotal($_SESSION['userHand']);
            $_SESSION['dealerHandTotal'] = GameBoard::calculateTotal($_SESSION['dealerHand']);
        }
    }

    public function createAction()
    {
        $name = $_SESSION['playerName'] = $_POST['name'];
        $delay = $_SESSION['delay'] = $_POST['delay'];
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION["game"]=true;
            $this->board = new GameBoard($name, $delay);
            $this->board->newGame();
        }
        header('Location: '.'/');
    }
    public function logout()
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

    public function newRoundAction()
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