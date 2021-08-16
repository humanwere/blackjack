<?php

namespace App\Models;

use App\Models\Card;
class Deck {

    // Standards https://en.wikipedia.org/wiki/Standard_52-card_deck
    /** Card types for creating deck  */
    const CardTypes = ['Clubs','Diamonds','Hearts','Spades'];
    /** Card ranks and their values for the game  */
    const CardRanks = [
        '2'     => 2,
        '3'     => 3,
        '4'     => 4,
        '5'     => 5,
        '6'     => 6,
        '7'     => 7,
        '8'     => 8,
        '9'     => 9,
        '10'    => 10,
        'J'     => 10,
        'Q'     => 10,
        'K'     => 10,
        'A'     => 11,
    ];

    /**
     * Method will create a fresh deck
     *
     * @return array
     */
    public static function createDeck()
    {
        $deck = [];
        foreach (self::CardTypes as $type){
            foreach (self::CardRanks as $name=>$rank){

                $card = [
                    'type'      => $type,
                    'name'      => $name,
                    'rank'      => $rank,
                ];
                $deck[] = $card;
            }
        }

        return $deck;
    }




}