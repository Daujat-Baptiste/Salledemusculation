<?php

namespace App\Controller;

use App\Repository\AccueilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ErrorController extends AbstractController
{
    /**
     * @Route("/error", name="error")
     */
    public function error(AccueilRepository $repository)
    {
        return $this->redirectToRoute("index", [
            'article'=>$repository->findAll()]);
    }
}
