<?php

namespace App\Controller;

use App\Repository\AbonnementRepository;
use App\Repository\RubriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    public function index(RubriqueRepository $repository)
    {
        $rubriques = $repository->findAll();
        return $this->render('menu.html.twig', [
            'rubriques' => $rubriques,
        ]);
    }

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
