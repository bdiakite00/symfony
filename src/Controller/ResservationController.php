<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResservationController extends AbstractController
{
    /**
     * @Route("/resservation", name="resservation")
     */
    public function index(): Response
    {
        return $this->render('resservation/index.html.twig', [
            'controller_name' => 'ResservationController',
        ]);
    }
}
