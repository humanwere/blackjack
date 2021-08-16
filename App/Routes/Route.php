<?php

use App\Controllers\Controller;
session_start();
$uri = $_SERVER['REQUEST_URI'];
$controller = new Controller();
if($uri == "/") {
    $controller->indexAction();
}elseif($uri == "/create"){
    $controller->createAction();
}elseif($uri=='/hit'){

    $controller->hitAction();

}elseif($uri=='/stay'){

    $controller->stayAction();

}elseif($uri=='/new-round'){

    $controller->newRoundAction();

}elseif($uri == "/logout"){

    $controller->logout();

}