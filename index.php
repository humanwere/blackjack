<?php
session_start();
require_once __DIR__.'/vendor/autoload.php';

use App\Controllers\Controller;

$uri = $_SERVER['REQUEST_URI'];

if(isset($_GET['logout']) && $_GET['logout']){
    Controller::logout();
}elseif($uri=="/"){
    $controller = new Controller();
    $controller->indexAction();
}

$card = $_SESSION['card'];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>BlackJack</title>
    <!-- Bootstrap core CSS -->
    <link href="public/assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>


</head>
<body>

<main>
    <div class="container py-4">
        <header class="pb-3 mb-4 border-bottom">
            <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="red" class="bi bi-suit-heart-fill" viewBox="0 0 16 16">
                    <path d="M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1z"/>
                </svg>
                </svg>
                <span class="fs-4 m-1"> BlackJack</span>
            </a>
        </header>

        <div class="p-5 mb-4 bg-light rounded-3">
            <div class="container-fluid py-5 row">
                <div class="col-md-9">
                    <div class="p-5 text-white bg-success rounded-3">
                        <h2>Dealer Hand ($total)</h2>
                        <p>Cards</p>
                    </div>
                    <div class="p-5 text-white bg-success rounded-3 mt-2">
                        <h2>Player Hand (total: <?=$card['rank'] ?>)</h2>
                        <div class="row text-dark text-center">
                            <div class="col-3 p-2">
                                <div class="card p-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="<?=$card['color'] ?>" class="card-img" viewBox="0 0 16 16">
                                        <path d="<?=$card['shapePath'] ?>"/>
                                    </svg>
                                    <div class="card-body">
                                        <h6 class="card-title"><?=$card['name'] ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="button">Hit!</button>
                        <button class="btn btn-warning" type="button">Stay</button>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title border-bottom pb-3">Stats</h5>
                            <p class="card-text">Remaining Card : <?=count($_SESSION['stack']) ?></p>
                            <p class="card-text">Dealer Wins : <?=count($_SESSION['stack']) ?></p>
                            <p class="card-text">Player Wins : <?=count($_SESSION['stack']) ?></p>
                            <a href="index.php?logout=true" class="btn btn-outline-danger pull-right"> Reset</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>

