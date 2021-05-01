<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Entity\Souscrire;
use App\Entity\User;
use App\Form\AbonnementType;
use App\Form\SouscrireType;
use App\Repository\AbonnementRepository;
use App\Repository\SouscrireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/abonnement")
 */
class AbonnementController extends AbstractController
{
    /**
     * @Route("/", name="abonnement_index", methods={"GET"})
     *
     * @param AbonnementRepository $abonnementRepository
     * @return Response
     */
    public function index(AbonnementRepository $abonnementRepository): Response
    {
        return $this->render('abonnement/listeabonnement.html.twig', [
            'abonnements' => $abonnementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/all", name="abonnement_base", methods={"GET"})
     * @param AbonnementRepository $abonnementRepository
     * @return Response
     */
    public function indexAb(AbonnementRepository $abonnementRepository): Response
    {
        return $this->render('abonnement/index.html.twig', [
            'abonnements' => $abonnementRepository->findAll(),
        ]);
    }


    /**
     * @Route("/new", name="abonnement_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $abonnement = new Abonnement();
        $form = $this->createForm(AbonnementType::class, $abonnement);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $newFilename = uniqid() . '.' . $image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('abonnement_directory'),
                        $newFilename
                    );
                } catch (FileException $exception) {
                    $this->addFlash('error', 'Une erreur est survenue lors de la récupération de l\'image');
                }

                $abonnement->setImage($newFilename);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($abonnement);
                $entityManager->flush();
            }

        }

        return $this->render('abonnement/new.html.twig', [
            'abonnement' => $abonnement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="abonnement_show", methods={"GET"})
     */
    public function show(Abonnement $abonnement): Response
    {
        return $this->render('abonnement/show.html.twig', [
            'abonnement' => $abonnement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="abonnement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Abonnement $abonnement): Response
    {
        $form = $this->createForm(AbonnementType::class, $abonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            if ($image) {
                $newFilename = uniqid() . '.' . $image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('abonnement_directory'),
                        $newFilename
                    );
                } catch (FileException $exception) {
                    $this->addFlash('error', 'Une erreur est survenue lors de la récupération de l\'image');
                }

                $abonnement->setImage($newFilename);
                $this->getDoctrine()->getManager()->flush();

                return $this->redirectToRoute('abonnement_index');
            }
        }
        return $this->render('abonnement/edit.html.twig', [
            'abonnement' => $abonnement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="abonnement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Abonnement $abonnement): Response
    {
        if ($this->isCsrfTokenValid('delete' . $abonnement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($abonnement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('abonnement_index');
    }

    /**
     * @Route("/info/{id}", name="abonnement_info", methods={"GET"})
     */
    public function info(Abonnement $abonnement): Response
    {
        return $this->render('abonnement/info.html.twig', [
            'abonnement' => $abonnement,
        ]);
    }


}
