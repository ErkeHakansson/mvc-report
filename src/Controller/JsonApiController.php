<?php

// Folder name

namespace App\Controller;

use App\CardGame\CardHand;
use App\CardGame\DeckOfCards;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class JsonApiController
{
    // Landningssida för routen api.html.twig
    #[Route("api/", name: "api")]
    public function jsonApi(): Response
    {

        $data = [
            'Api' => "Card game",
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }


    #[Route("api/quote", name: "api_quote")]
    public function jsonQuote(): Response
    {

        // Set the timezone to use
        date_default_timezone_set('Europe/Stockholm');

        // The date of today
        $today = date('Y-m-d');

        $quoteArray = array(
            "Practice makes perfect",
            "An apple a day keeps the doctor away",
            "Rome was not built in a day",
            "A Cat Has Nine Lives",
            "A Bird in the Hand is Worth Two in the Bush"
        );

        $quoteRandom = $quoteArray[mt_rand(0, count($quoteArray)-1)];

        $time = time();
        $timestamp = date('d M Y H:i:s', $time);


        $data = [
            'Dagens datum' => $today,
            'Dagens citat' => $quoteRandom,
            'Tidsstämpel' => $timestamp,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck", name: "api_deck", methods: ['GET'])]
    public function jsonApiDeck(): Response
    {

        $cards = new DeckOfCards();  // Skapar nytt objekt

        $data = [
            "cardsSpades" => $cards->getValueSpades(),
            "cardsHearts" => $cards->getValueHearts(),
            "cardsDiamonds" => $cards->getValueDiamonds(),
            "cardsClubs" => $cards->getValueClubs(),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }


    #[Route("/api/deck/shuffle", name: "api_deck_shuffle_post", methods: ['GET', 'POST'])]
    public function jsonApiShuffle_post(): Response
    {

        $hand = new CardHand(); // Nytt hand object
        $cardsShuffled = $hand->shuffleCards_json(); // Hämtar method med 52 shuffled cards från classen CardHand

        $data = [
            "cardsShuffled" => $cardsShuffled,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }


    #[Route("/api/deck/draw", name: "api_deck_draw", methods: ['GET', 'POST'])]
    public function jsonApiDraw_post(
        SessionInterface $session
    ): Response {

        $hand = new CardHand(); // Nytt hand object
        $cardsShuffled = $hand->shuffleCards_json(); // Hämtar method med 52 shuffled cards

        $numCardsLeft = count($cardsShuffled); // Number of cards from början - 52

        $cards_left_in_array = $session->get("cards_left_in_array_json", $cardsShuffled); // får result array sparat i session !

        // Visar one card from main array
        $one_card = array_slice(array_unique($cards_left_in_array), 0, 1);

        // Removing one card from cards deck med array_diff funktion
        $result_diff = array_diff(array_values($cards_left_in_array), array_unique($one_card)); // finding differences between two arrays, t.ex. 52 - 1 = 51

        // Skapar session
        $session->set("cards_left_in_array_json", $result_diff); // 52 - 1 = 51


        $numCardsLeft_new = count($cards_left_in_array);

        //Återställa kortleken when number of cards <= 1 - börja om från 52 kort
        if (count($cards_left_in_array) <= 1) {
            session_unset();
        }

        $data = [
            "draw_one_card" => $one_card,  // draw one card
            "num_cards_left" => $numCardsLeft_new, // beräknar antal kort kvar
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw/five", name: "api_deck_draw_number", methods: ['GET', 'POST'])]
    public function jsonApiDrawNumber_post(
        SessionInterface $session
    ): Response {

        $hand = new CardHand(); // Nytt hand object
        $cardsShuffled = $hand->shuffleCards_json(); // Hämtar method med 52 shuffled cards

        $numCardsLeft = count($cardsShuffled); // Number of cards from början - 52

        $cards_left_in_array = $session->get("cards_left_in_array_json_five", $cardsShuffled); // får result array sparat i session

        // Visar fem cards from main array
        $five_cards = array_slice(array_unique($cards_left_in_array), 0, 5);

        // Removing five cards from cards deck med array_diff funktion
        $result_diff = array_diff(array_values($cards_left_in_array), array_unique($five_cards)); // finding differences between two arrays, t.ex. 52 - 5 = 47

        // Skapar session
        $session->set("cards_left_in_array_json_five", $result_diff); // 52 - 5 = 47

        $numCardsLeft_new = count($cards_left_in_array);

        //Återställa kortleken when number of cards < 5 - börja om från 52 kort
        if (count($cards_left_in_array) <= 3) {
            session_unset();
        }

        $data = [
            "draw_five_cards" => $five_cards,  // draw five cards
            "num_cards_left" => $numCardsLeft_new, // antal kort kvar
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
