<?php

// Folder name

namespace App\Controller;

use App\CardGame\CardHand;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    // Landningssida - förstasida card.html.twig (name: innehåller name of path: card)
    #[Route("/card", name: "card")]
    public function card(): Response
    {
        return $this->render('card/card.html.twig');
    }

    #[Route("/card/deck", name: "deck")]
    public function deck(): Response
    {
        return $this->render('card/deck/deck.html.twig'); // Filen är i underkatalog deck i templates
    }

    #[Route("/card/deck/shuffle", name: "deck_shuffle")]
    public function deckShuffle(): Response
    {
        {
            $hand = new CardHand(); // Nytt hand object
            $cardsShuffled = $hand->shuffleCards(); // Hämtar method med 52 shuffled cards

            $data = [
                "num_cards" => count($cardsShuffled), // beräknar antal cards
                "cardShuffle" => $cardsShuffled, // visar shuffled array
            ];
        }

        return $this->render('card/deck/deck_shuffle.html.twig', $data);
    }


    #[Route("/card/deck/draw/", name: "deck_draw")]
    public function deckDraw(
        SessionInterface $session
    ): Response {

        $hand = new CardHand(); // Nytt hand object
        $cardsShuffled = $hand->shuffleCards(); // Hämtar method med 52 shuffled cards

        $numCardsLeft = count($cardsShuffled); // Number of cards from början - 52
        //var_dump($numCardsLeft); // 52

        $cards_left_in_array = $session->get("cards_left_in_array_one", $cardsShuffled); // får result array sparat i session !
        //var_dump($cards_left_in_array); // 51

        // Visar one card from main array
        $one_card = array_slice(array_unique($cards_left_in_array), 0, 1);
        //var_dump($one_card);

        // Removing one card from cards deck med array_diff funktion
        $result_diff = array_diff(array_values($cards_left_in_array), array_unique($one_card)); // finding differences between two arrays, t.ex. 52 - 1 = 51
        //var_dump($result_diff); // 51


        // Skapar session !
        $session->set("cards_left_in_array_one", $result_diff); // 52 - 1 = 51


        $numCardsLeft_new = count($cards_left_in_array);
        //var_dump($numCardsLeft_new); // !

        //Återställa kortleken when number of cards <= 1 - börja om från 52 kort
        if (count($cards_left_in_array) <= 1) {
            session_unset();
        }


        $data = [
            "draw_one_card" => $one_card,
            "num_cards_left_draw_one" => $numCardsLeft_new, // beräknar antal kort kvar
        ];

        return $this->render('card/deck/deck_draw.html.twig', $data);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "deck_draw_number")]
    public function deckDraw_Number(
        int $num,
        SessionInterface $session
    ): Response {

        $hand = new CardHand(); // Nytt hand object
        $cardsShuffled = $hand->shuffleCards(); // Hämtar method med 52 shuffled cards

        $numCardsLeft = count($cardsShuffled); // Number of cards from början - 52
        //var_dump($numCardsLeft); // 52

        $cards_left_in_array = $session->get("cards_left_in_array_five", $cardsShuffled); // får result array sparat i session !
        //var_dump($cards_left_in_array); // 47

        // Visar fem cards from main array
        $five_cards = array_slice(array_unique($cards_left_in_array), 0, 5);
        //var_dump($five_cards);

        // Removing five cards from cards deck med array_diff funktion
        $result_diff = array_diff(array_values($cards_left_in_array), array_unique($five_cards)); // finding differences between two arrays, t.ex. 52 - 5 = 47
        //var_dump($result_diff); // 47


        // Skapar session !
        $session->set("cards_left_in_array_five", $result_diff); // 52 - 5 = 47


        $numCardsLeft_new = count($cards_left_in_array);
        //var_dump($numCardsLeft_new); // !

        //Återställa kortleken when number of cards < 5 - börja om från 52 kort
        if (count($cards_left_in_array) <= $num) {
            session_unset();
        }


        $data = [
            "draw_five_cards" => $five_cards,  // five cards
            "num_cards_left_draw_five" => $numCardsLeft_new, // antal kort kvar
        ];

        return $this->render('card/deck/deck_draw_number.html.twig', $data);
    }

}
