<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{
    // Kmom01 routes i navbaren
    #[Route("/", name: "me")]
    public function me(): Response
    {
        return $this->render('me.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/lucky", name: "lucky_number")]
    public function number(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'number' => $number
        ];

        return $this->render('lucky_number.html.twig', $data);
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    // Kmom02 - two new routes i navbaren: api, card
    #[Route("/api", name: "api")]
    public function jsonApi(): Response
    {
        return $this->render('api/api.html.twig');
    }

    #[Route("/card", name: "card")]
    public function card(): Response
    {
        return $this->render('card/card.html.twig');
    }

}
