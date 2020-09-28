<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RedacteurController extends AbstractController
{
    /**
     * @Route("/redacteur", name="redacteur")
     */
    public function index()
    {
        return $this->render('redacteur/index.html.twig', [
            'controller_name' => 'RedacteurController',
        ]);
    }
}
