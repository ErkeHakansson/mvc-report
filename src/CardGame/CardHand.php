<?php

namespace App\CardGame;

// Composition -> Aggregat composition

class CardHand
{
    // Används i CardGameController
    public function shuffleCards(): array
    {
        $cardsGr = new CardGraphic(); // Skapar nytt objekt
        $cardsToShuffle = $cardsGr->getVariable(); // hämtar variabel-array med grafisk representation of cards from class CardGraphic
        shuffle($cardsToShuffle); // använder inbyggd funktion shuffle för den hämtade arrayern

        return $cardsToShuffle; // Returnerar array med 52 shuffled cards
    }

    // Används i JsonApiController
    public function shuffleCards_json(): array
    {
        $cardsGr = new DeckOfCards(); // Skapar nytt objekt
        $cardsToShuffleJson = $cardsGr->getValue(); // hämtar variabel-array med 52 cards from class DeckOfCards
        shuffle($cardsToShuffleJson); // använder inbyggd funktion shuffle för den hämtade arrayern

        return $cardsToShuffleJson; // Returnerar array med 52 shuffled cards
    }
}
