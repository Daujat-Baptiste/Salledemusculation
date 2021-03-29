<?php

namespace App\Controller;

use App\Entity\Accueil;
use App\Entity\Article;
use App\Form\AccueilType;
use App\Form\ArticleType;
use App\Repository\AccueilRepository;
use App\Repository\ArticleRepository;
use App\Repository\RubriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{

    /**
     * @Route("/creerarticle", name="create_article")
     */
    public function create(Request $request, RubriqueRepository $repository, ArticleRepository $repositoryArt)
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
    public function deleteArticle($id, ArticleRepository $repository, AccueilRepository $accueilRepository)
    {
        $article = $repository->find($id);
        $accueil = $accueilRepository->findBy(['actif' => 'actif']);

        if ($accueil[0]->getArticle()->getId() == $id) {
            $this->addFlash('danger', 'L\'article ne peut pas être supprimé car il est affiché sur l\'accueil');
        } else {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($article);
            $entityManager->flush();
            $this->addFlash('success', 'L\'article a été supprimé');
        }

        $repoArticleAll = $repository->findAll();
        return $this->render('article/gererArticle.html.twig',
            ['articles' => $repoArticleAll,
            ]);
    }

    /**
     * @Route("/gererarticle/edit/{id}", name="editArticle")
     */
    public function editArticle($id, ArticleRepository $repository, Request $request)
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
    public function Article(ArticleRepository $repository, $id)
    {
        if (empty($repository->find($id))) {
            return $this->redirectToRoute("listerubriques");
        }else{
            return $this->render('article/articleinfo.html.twig',
                ['article' => $repository->find($id),
                ]);
        }
    }


/**
 * @Route("/accueil/{id}", name="send_accueil")
 */
public
function send_accueil(ArticleRepository $articleRepository, $id, AccueilRepository $accueilRepository)
{
    $article = $articleRepository->find($id);
    $accueil = $accueilRepository->findBy(['actif' => 'actif']);

    if ($accueil == null) {
        $entityManager = $this->getDoctrine()->getManager();
        $accueil = new Accueil();
        $accueil->setActif('actif');
        $accueil->setArticle($article);
        $entityManager->persist($accueil);
        $entityManager->flush();
    } else {
        $accueil[0]->setArticle($article);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
    }
    return $this->render('article/gererArticle.html.twig', [
        'articles' => $articleRepository->findAll()
    ]);
}

}
