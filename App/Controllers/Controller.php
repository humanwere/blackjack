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
        if (session_status() === PHP_SESSION_NONE) {
            if(!isset($_SESSION["game"])){
                $_SESSION["game"]=true;
            }
        }

        $card  = $this->board->pullCard();
        var_dump($card);
    }

    public static function logout()
    {
        session_destroy();
        session_unset();
        header('Location: '.'/');
    }

}