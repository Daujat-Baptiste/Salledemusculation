<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\RubriqueRepository;
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
     * @Route("/creerarticle", name="create_article")
     */
    public function create(Request $request, RubriqueRepository $repository,ArticleRepository $repositoryArt)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            $repoArticleAll = $repositoryArt->findAll();
            return $this->render('article/gererArticle.html.twig',
                ['articles' => $repoArticleAll,
                ]);
        }
        return $this->render('article/creerArticle.html.twig', [
            'articleForm' => $form->createView(),
            'rubriques' => $repository->findAll(),
        ]);
    }
    /**
     * @Route("/gererarticle", name="gerer_article")
     */
    public function gererArticle(ArticleRepository $repository)
    {
        return $this->render('article/gererArticle.html.twig',
            ['articles' => $repository->findAll(),
            ]);
    }

    /**
     * @Route("/gererarticle/delete/{id}", name="deleteArticle")
     */
    public function deleteArticle($id,ArticleRepository $repository)
    {
        $article = $repository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($article);
        $entityManager->flush();
        $repoArticleAll = $repository->findAll();
        return $this->render('article/gererArticle.html.twig',
            ['articles' => $repoArticleAll,
            ]);
    }

    /**
     * @Route("/gererarticle/edit/{id}", name="editArticle")
     */
    public function editArticle($id,ArticleRepository $repository,Request $request)
    {
        $article = $repository->find($id);
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $repoArticleAll = $repository->findAll();
            return $this->render('article/gererArticle.html.twig',
                ['articles' => $repoArticleAll,
                ]);
        }

        return $this->render('article/editArticle.html.twig',
            ['article' => $article,
                'form' => $form->createView(),
            ]);
    }
    /**
     * @Route("/article/{id}", name="articleinfo")
     */
    public function Article(ArticleRepository $repository,$id)
    {
        return $this->render('article/articleinfo.html.twig',
            ['article' => $repository->find($id),
            ]);
    }
    


}
