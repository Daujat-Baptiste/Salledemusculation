<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdministrationController extends AbstractController
{
    /**
     * @Route("/menuAdmin", name="administration")
     */
    public function index()
    {
        return $this->render('administration/index.html.twig');
    }
}
