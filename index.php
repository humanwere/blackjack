<?php
require_once __DIR__.'/vendor/autoload.php';

use App\Controllers\Controller;

$uri = $_SERVER['REQUEST_URI'];
session_start();

$cardDesign = [
    'C' => [
        'path'  => 'M11.5 12.5a3.493 3.493 0 0 1-2.684-1.254 19.92 19.92 0 0 0 1.582 2.907c.231.35-.02.847-.438.847H6.04c-.419 0-.67-.497-.438-.847a19.919 19.919 0 0 0 1.582-2.907 3.5 3.5 0 1 1-2.538-5.743 3.5 3.5 0 1 1 6.708 0A3.5 3.5 0 1 1 11.5 12.5z',
        'color' => 'black'
    ],
    'D' => [
        'path'  => 'M2.45 7.4 7.2 1.067a1 1 0 0 1 1.6 0L13.55 7.4a1 1 0 0 1 0 1.2L8.8 14.933a1 1 0 0 1-1.6 0L2.45 8.6a1 1 0 0 1 0-1.2z',
        'color' => 'red'
    ],
    'H' => [
        'path'  => 'M4 1c2.21 0 4 1.755 4 3.92C8 2.755 9.79 1 12 1s4 1.755 4 3.92c0 3.263-3.234 4.414-7.608 9.608a.513.513 0 0 1-.784 0C3.234 9.334 0 8.183 0 4.92 0 2.755 1.79 1 4 1z',
        'color' => 'red'
    ],
    'S' => [
        'path'  => 'M7.184 11.246A3.5 3.5 0 0 1 1 9c0-1.602 1.14-2.633 2.66-4.008C4.986 3.792 6.602 2.33 8 0c1.398 2.33 3.014 3.792 4.34 4.992C13.86 6.367 15 7.398 15 9a3.5 3.5 0 0 1-6.184 2.246 19.92 19.92 0 0 0 1.582 2.907c.231.35-.02.847-.438.847H6.04c-.419 0-.67-.497-.438-.847a19.919 19.919 0 0 0 1.582-2.907z',
        'color' => 'black'
    ]
];
$controller = new Controller();
if($uri=="/logout"){
    Controller::logout();
}elseif($uri=="/"){
    $controller->indexAction();
}elseif($uri=='/hit'){
    $controller->hitAction();
}elseif($uri=='/stay'){
    $controller->stayAction();
}elseif($uri=='/new-round'){
    $controller->newRound();
}
$userHand = $_SESSION['userHand'];
$dealerHand = $_SESSION['dealerHand'];

$userTotal = \App\Models\GameBoard::calculateTotal($userHand);

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
<body class="bg-light">
    <div class="container">
            <div class="container-fluid py-5 row">
                <div class="col-md-9">
                    <!-- BEGIN::DEALER -->
                    <?php
                    if(isset($_SESSION['message'])){
                        echo '<div class="alert alert-primary" role="alert">'.$_SESSION['message'].'</div>';
                    }
                    ?>
                    <div class="p-5 text-white bg-success rounded-3">
                        <h2>Dealer Hand :</h2>
                        <div class="row text-dark text-center">
                            <?php
                            $total = 0;
                            $count = 0;
                            foreach ($dealerHand as $card){

                                if($_SESSION['round']===true && $count==0){
                            ?>
                                    <div class="col-3 p-2">
                                        <div class="card p-3 bg-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="110" fill="currentColor" class="card-img" viewBox="0 0 16 16">
                                                <path d="M3 4.075a.423.423 0 0 0 .43.44H4.9c.247 0 .442-.2.475-.445.159-1.17.962-2.022 2.393-2.022 1.222 0 2.342.611 2.342 2.082 0 1.132-.668 1.652-1.72 2.444-1.2.872-2.15 1.89-2.082 3.542l.005.386c.003.244.202.44.446.44h1.445c.247 0 .446-.2.446-.446v-.188c0-1.278.487-1.652 1.8-2.647 1.086-.826 2.217-1.743 2.217-3.667C12.667 1.301 10.393 0 7.903 0 5.645 0 3.17 1.053 3.001 4.075zm2.776 10.273c0 .95.758 1.652 1.8 1.652 1.085 0 1.832-.702 1.832-1.652 0-.985-.747-1.675-1.833-1.675-1.04 0-1.799.69-1.799 1.675z"/>
                                            </svg>
                                            <div class="card-img-overlay">
                                                <h6 class="card-title">&nbsp;</h6>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }else{
                                    $total +=$card['rank'];
                            ?>
                                <div class="col-3 p-2">
                                    <div class="card p-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="<?=$cardDesign[$card['type']]['color'] ?>" class="card-img" viewBox="0 0 16 16">
                                            <path d="<?=$cardDesign[$card['type']]['path'] ?>"/>
                                        </svg>
                                        <div class="card-body">
                                            <h6 class="card-title"><?=$card['name'] ?></h6>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                }
                                $count++;
                            }
                            ?>
                        </div>
                        <h3>Total : <?= $_SESSION['round'] ? $total : \App\Models\GameBoard::calculateTotal($dealerHand)  ?></h3>
                    </div>
                    <!-- END::DEALER -->

                    <!-- BEGIN::USER -->
                    <div class="p-5 text-white bg-success rounded-3 mt-2">
                        <h2>Player Hand : </h2>
                        <div class="row text-dark text-center">
                            <?php
                            unset($card);
                            foreach ($userHand as $card){
                            ?>
                            <div class="col-3 p-2">
                                <div class="card p-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="<?=$cardDesign[$card['type']]['color'] ?>" class="card-img" viewBox="0 0 16 16">
                                        <path d="<?=$cardDesign[$card['type']]['path'] ?>"/>
                                    </svg>
                                    <div class="card-body">
                                        <h6 class="card-title"><?=$card['name'] ?></h6>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                        <h3>Total : <?=$userTotal ?></h3>
                        <?php
                        if($_SESSION['round']){
                            if($userTotal<21){
                                echo '<a href="/hit" class="btn btn-primary">Hit!</a> ';
                            }
                            echo '<a href="/stay" class="btn btn-warning">Stay</a> ';
                        }else{
                            echo '<a href="/new-round" class="btn btn-danger">New Round</a> ';
                        }
                        ?>

                    </div>
                    <!-- END::USER -->

                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title border-bottom pb-3">Stats</h5>
                            <p class="card-text">Remaining Card : <?=count($_SESSION['stack']) ?></p>
                            <p class="card-text">Player Win Count : <?=$_SESSION['userWinCount'] ?></p>
                            <p class="card-text">Dealer Win Count : <?=$_SESSION['dealerWinCount'] ?></p>
                            <a href="/logout" class="btn btn-outline-danger pull-right"> Reset</a>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</body>
</html>

