<?php

namespace App\Controller;

use App\Repository\RubriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    public function index(RubriqueRepository $repository,$max=50)
    {
        $rubriques = $repository->findAll();
        return $this->render('menu.html.twig', [
            'rubriques' => $rubriques,
        ]);
    }
}
