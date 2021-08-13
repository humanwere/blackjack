<?php
require_once __DIR__.'/vendor/autoload.php';

use App\Models\GameBoard;

$board = new GameBoard();

echo "<pre>";
var_dump($board->pullCard());
var_dump($board->stack);
echo "</pre>";