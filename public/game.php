<div class="container">
    <div class="container-fluid py-5 row">
        <div class="col-md-9">
            <!-- BEGIN::DEALER -->
            <?php
            if(isset($_SESSION['message'])){
            ?>
                <div class="alert alert-primary" role="alert"><?=$_SESSION['message']?>. New round starts in:  <span id="countdown">10</span></div>
                <script type="text/javascript">

                    // Total seconds to wait
                    var seconds = <?= $_SESSION['delay']?>;

                    function countdown() {
                        seconds = seconds - 1;
                        if (seconds < 0) {
                            // Chnage your redirection link here
                            window.location = "/new-round";
                        } else {
                            // Update remaining seconds
                            document.getElementById("countdown").innerHTML = seconds;
                            // Count down using javascript
                            window.setTimeout("countdown()", 1000);
                        }
                    }

                    // Run countdown function
                    countdown();

                </script>
            <?php
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
                            $total +=$card->getRank();
                            ?>
                            <div class="col-3 p-2">
                                <div class="card p-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="<?=$cardDesign[$card->getType()]['color'] ?>" class="card-img" viewBox="0 0 16 16">
                                        <path d="<?=$cardDesign[$card->getType()]['path'] ?>"/>
                                    </svg>
                                    <div class="card-body">
                                        <h6 class="card-title"><?=$card->getName() ?></h6>
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
                <h2><?=$_SESSION['playerName'] ?>'s Hand : </h2>
                <div class="row text-dark text-center">
                    <?php
                    unset($card);
                    foreach ($userHand as $card){
                        ?>
                        <div class="col-3 p-2">
                            <div class="card p-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="<?=$cardDesign[$card->getType()]['color'] ?>" class="card-img" viewBox="0 0 16 16">
                                    <path d="<?=$cardDesign[$card->getType()]['path'] ?>"/>
                                </svg>
                                <div class="card-body">
                                    <h6 class="card-title"><?=$card->getName() ?></h6>
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