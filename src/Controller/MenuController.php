<?php

namespace App\Controller;

use App\Repository\AbonnementRepository;
use App\Repository\RubriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    /**
     * @Route("/abonnements", name="listeabonnements", methods={"GET"})
     */
    public function liste(AbonnementRepository $abonnementRepository)
    {

        return $this->render('abonnement/listeabonnement.html.twig',
            ['abonnements' => $abonnementRepository->findAll(),
            ]);
    }
}
