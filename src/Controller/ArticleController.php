<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function create(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
        }
        return $this->render('article/creerArticle.html.twig',[
            'articleForm' => $form->createView(),
        ]);
    }
    /**
     * @Route("/article/gerer", name="gerer_article")
     */
    public function gerer()
    {
        return $this->render('article/gererArticle.html.twig');
    }

    /**
     * @Route("/article/{id}", name="articleinfo")
     */
    public function article(ArticleRepository $repository,$id)
    {
        $article=$repository->find($id);
        return $this->render('article/article.html.twig',['article'=>$article]);
    }


}
