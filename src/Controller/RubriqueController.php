<?php

namespace App\Controller;

use App\Entity\Rubrique;
use App\Form\RubriqueType;
use App\Repository\RubriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RubriqueController extends AbstractController
{
    /**
     * @Route("/rubrique", name="rubrique")
     */
    public function index()
    {
        return $this->render('rubrique/index.html.twig');
    }

    /**
     * @Route("/creerrubrique", name="creerRubrique")
     */
    public function creerRubrique(Request $request)
    {
        $rubrique = new Rubrique();
        $form = $this->createForm(RubriqueType::class, $rubrique);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rubrique);
            $entityManager->flush();
        }
        return $this->render('rubrique/creerRubrique.html.twig', [
            'rubriqueForm' => $form->createView(),
        ]);
    }


    /**
     * @Route("/gererrubrique", name="gererRubrique")
     */
    public function gererRubrique(RubriqueRepository $repository, Request $request)
    {
        $rubrique = new Rubrique();
        $form = $this->createForm(RubriqueType::class, $rubrique);
        $form->handleRequest($request);
        $repoRubriqueAll = $repository->findAll();
        return $this->render('rubrique/gererRubrique.html.twig',
            ['rubriques' => $repoRubriqueAll,
                'form' => $form->createView(),
            ]);
    }

    /**
     * @Route("/gererrubrique/delete/{id}", name="deleteRubrique")
     */
    public function deleteRubrique($id,RubriqueRepository $repository)
    {
        $rubrique = $repository->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($rubrique);
        $entityManager->flush();
        $repoRubriqueAll = $repository->findAll();
        return $this->render('rubrique/gererRubrique.html.twig',
            ['rubriques' => $repoRubriqueAll,
            ]);
    }

    /**
     * @Route("/gererrubrique/edit/{id}", name="editRubrique")
     */
    public function editRubrique($id,RubriqueRepository $repository,Request $request)
    {
        $rubrique = $repository->find($id);
        $form = $this->createForm(RubriqueType::class, $rubrique);
        $form->handleRequest($request);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        if ($form->isSubmitted() && $form->isValid()) {
            $repoRubriqueAll = $repository->findAll();
            return $this->render('rubrique/gererRubrique.html.twig',
                ['rubriques' => $repoRubriqueAll,
                ]);
        }

        return $this->render('rubrique/editRubrique.html.twig',
            ['rubrique' => $rubrique,
                'form' => $form->createView(),
            ]);
    }
}
