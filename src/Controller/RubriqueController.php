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
     * @Route("/creerRubrique", name="creerRubrique")
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
     * @Route("/gererRubrique", name="gererRubrique")
     */
    public function gererRubrique(RubriqueRepository $repository, Request $request)
    {
        $rubrique = new Rubrique();
        $form = $this->createForm(RubriqueType::class, $rubrique);
        $form->handleRequest($request);

            return $this->render('rubrique/gererRubrique.html.twig',
                ['form' => $form->createView()]);
        }
    }
