<?php

namespace App\Controller;

use App\Entity\Redacteur;
use App\Form\RedacteurType;
use App\Repository\RedacteurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RedacteurController extends AbstractController
{
    /**
     * @Route("/redacteur", name="redacteur")
     */
    public function index()
    {
        return $this->render('redacteur/index.html.twig');
    }

    /**
     * @Route("/creerredacteur", name="create_redacteur")
     */
    public function create(Request $request, RedacteurRepository $repository)
    {
        $redacteur = new Redacteur();
        $form = $this->createForm(RedacteurType::class, $redacteur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($redacteur);
            $entityManager->flush();

            return $this->render('redacteur/gererRedacteur.html.twig',
                ['redacteurs' => $repository->findAll(),
                ]);
        }
        return $this->render('redacteur/createRedacteur.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/gererredacteur", name="gerer_redacteur")
     */
    public function gererArticle(RedacteurRepository $repository)
    {
        $redacteur = new Redacteur();
        return $this->render('redacteur/gererRedacteur.html.twig',
            ['redacteurs' => $repository->findAll(),
            ]);
    }

    /**
     * @Route("/gererredacteur/delete/{id}", name="deleteRedacteur")
     */
    public function deleteArticle($id, RedacteurRepository $repository)
    {
        $redacteur = $repository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($redacteur);
        $entityManager->flush();
        return $this->render('redacteur/gererRedacteur.html.twig',
            ['redacteurs' => $repository->findAll(),
            ]);
    }

    /**
     * @Route("/gererredacteur/edit/{id}", name="editRedacteur")
     */
    public function editArticle($id, RedacteurRepository $repository, Request $request)
    {
        $redacteur = $repository->find($id);
        $form = $this->createForm(RedacteurType::class, $redacteur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->render('redacteur/gererRedacteur.html.twig',
                ['redacteurs' => $repository->findAll(),
                ]);
        }

        return $this->render('redacteur/editRedacteur.html.twig',
            ['redacteur' => $redacteur,
                'form' => $form->createView(),
            ]);
    }


}


