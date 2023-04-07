<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerJson
{
    #[Route("/api/quote")]
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
}
