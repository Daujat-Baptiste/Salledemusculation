<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index()
    {
        return $this->render('article/index.html.twig');
    }
    /**
     * @Route("/article/create", name="create_article")
     */
    public function create()
    {
        return $this->render('article/creerArticle.html.twig');
    }
    /**
     * @Route("/article/gerer", name="gerer_article")
     */
    public function gerer()
    {
        return $this->render('article/gererArticle.html.twig');
    }
}
