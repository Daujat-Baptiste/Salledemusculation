<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Repository\AbonnementRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(AbonnementRepository $repository)
    {
        $abonnementView = $repository->findAll();

        return $this->render('index/index.html.twig',['abonnements' => $abonnementView]);
    }
}
