<?php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/App/Routes/Route.php';
require_once __DIR__.'/App/Helper.php';


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
    <?php
    if(!isset($_SESSION["game"])){
        include('public/create.php');
    }else{
        $userHand = $_SESSION['userHand'];
        $dealerHand = $_SESSION['dealerHand'];
        $userTotal = \App\Models\GameBoard::calculateTotal($userHand);
        include('public/game.php');
    }

    ?>
</body>
</html>

