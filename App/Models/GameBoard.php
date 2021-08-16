<?php

namespace App\Models;

class GameBoard
{

    const DealerMaXHit = 17; // If the dealer has a less then this value hand the dealer gets a new card until the hand has 17 or more value
    const BlackJack = 21;
    protected mixed $playerName;
    protected mixed $delay;
    protected mixed $stack = null; // It will be filled with the number of decks declared in DeckCount
    protected mixed $dealerHand = null;
    protected mixed $userHand = null;

    /**
     * GameBoard constructor.
     *
     *
     */
    public function __construct($name, $delay)
    {
        $this->playerName = $name;
        $this->delay = $delay;
    }

    public function newGame()
    {
        $deck = new Deck();
        $this->stack = $_SESSION['stack'] = $deck->getStack();
        $this->setDealerHand(null);
        $this->setUserHand(null);
        $_SESSION['userWinCount'] = 0;
        $_SESSION['dealerWinCount'] = 0;
        $this->newRound();
    }

    /**
     * This method starts a new round
     */
    public function newRound()
    {
        // Take old cards
        $this->setDealerHand(null);
        $this->setUserHand(null);

        // Set round Session
        $_SESSION['round'] = true;

        // Message session unsetting for not show old messages in new round
        unset($_SESSION['message']);

        $this->pullCard('dealer');
        $this->pullCard('user');
        $this->pullCard('dealer');
        $this->pullCard('user');

        // Check for player Blackjack
        $this->checkWinner('new');
    }


    /**
     * Pull a new card from Stack and add the card to player's hand
     *
     * Param named player because Dealer is also a player
     * @param $player
     * @return mixed
     */
    public function pullCard($player): mixed
    {
        $stack = $_SESSION['stack'];
        $card = $stack[array_key_first($stack)];
        unset($stack[array_key_first($stack)]);
        if ($player == 'user') {
            $_SESSION['userHand'][] = $card;
            $this->setUserHand($_SESSION['userHand']);
        } elseif ($player == 'dealer') {
            $_SESSION['dealerHand'][] = $card;
            $this->setDealerHand($_SESSION['dealerHand']);
        }
        $_SESSION['stack'] = $stack;
        return $card;
    }

    /**
     * This method calculates player's hand total rank
     *
     * @param $hand
     * @return int
     */
    public static function calculateTotal($hand): int
    {
        $total = 0;
        $aceCount = 0;

        // Calculate total
        foreach ($hand as $card) {
            if ($card->getName() == 'A') { // if there is an Ace, increase count
                $aceCount++;
            }
            $total += $card->getRank();
        }

        // If hand has Aces, decrease total by 10 while the total greater than 21
        if ($aceCount > 0) {
            for ($i = 1; $i <= $aceCount; $i++) {
                if ($total > self::BlackJack) {
                    $total -= 10;
                }
            }
        }
        return $total;
    }

    /**
     * This method checks winner
     *
     * @param $status
     */
    public function checkWinner($status): void
    {
        if ($_SESSION['round']) {
            $userHandTotal = self::calculateTotal($_SESSION['userHand']);
            if ($status == "new" & $userHandTotal == self::BlackJack) { // If it's the beginning of the round, check the user have blackjack

                $this->dealerRoundEndProcess();
                $dealerHandTotal = self::calculateTotal($_SESSION['dealerHand']);
                $this->whoWins($dealerHandTotal, $userHandTotal, true);

            } elseif ($status == "hit") { // If player hitted, check the user have blackjack or over 21

                if ($userHandTotal > self::BlackJack) {

                    self::finishRound('dealer', 'Player busts! <b>Dealer Wins!</b>', false);

                } elseif ($userHandTotal == self::BlackJack) {

                    $this->dealerRoundEndProcess(); // dealer pull cards while it hand less than 17
                    $dealerHandTotal = self::calculateTotal($_SESSION['dealerHand']);
                    $this->whoWins($dealerHandTotal, $userHandTotal, true);

                }
            } elseif ($status == "stay") { // If player stays

                $this->dealerRoundEndProcess(); // dealer pull cards while it hand less than 17
                $dealerHandTotal = self::calculateTotal($_SESSION['dealerHand']);
                $this->whoWins($dealerHandTotal, $userHandTotal);

            }
        }
    }

    /**
     * This method checks win conditions
     *
     * @param $dealer
     * @param $user
     * @param false $blackJack
     */
    private function whoWins($dealer, $user, bool $blackJack = false)
    {
        $_SESSION['winnerHand'] = null;
        if ($dealer > self::BlackJack) {
            self::finishRound('user', 'Dealer Busts!! <b>Player Wins!</b>', $blackJack);
            $_SESSION['winnerHand'] = $_SESSION['userHand'];
        } elseif ($user > self::BlackJack) {
            self::finishRound('dealer', 'Player Busts!! <b>Dealer Wins!</b>', false);
            $_SESSION['winnerHand'] = $_SESSION['dealerHand'];
        } elseif ($dealer > $user) {
            self::finishRound('dealer', '<b>Dealer Wins!</b>', false);
            $_SESSION['winnerHand'] = $_SESSION['dealerHand'];
        } elseif ($dealer < $user) {
            self::finishRound('user', '<b>Player Wins!</b>', $blackJack);
            $_SESSION['winnerHand'] = $_SESSION['userHand'];
        } elseif ($dealer == $user) {
            self::finishRound('draw', '<b>Draw!</b>', false);
            $_SESSION['winnerHand'] = $_SESSION['userHand'];
        }
    }

    /**
     * This method is called when Round end conditions is met
     *
     */
    public function dealerRoundEndProcess()
    {
        $dealerHandTotal = self::calculateTotal($_SESSION['dealerHand']);
        while ($dealerHandTotal < self::DealerMaXHit) {// Pull card while dealer hand less than 17
            $this->pullCard('dealer');
            $dealerHandTotal = self::calculateTotal($_SESSION['dealerHand']);
        }
    }

    /**
     * This method returns Winner and alert message, also adds count to winner's stats
     *
     * @param $winner
     * @param $message
     * @param $blackJack
     */
    public static function finishRound($winner, $message, $blackJack)
    {
        $_SESSION['message'] = $blackJack ? 'Winner Winner, Chicken Dinner! ' . $message : $message;
        $_SESSION['round'] = false;
        if ($winner == 'user') {
            $_SESSION['userWinCount'] += 1;
        } elseif ($winner == "dealer") {
            $_SESSION['dealerWinCount'] += 1;
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