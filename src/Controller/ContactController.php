<?php

namespace App\Controller;


use App\Entity\Mail;
use App\Form\Mail1Type;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Form\MailType;
use App\Entity\Contact;
use App\Form\ContactFrontType;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ContactController extends AbstractController
{
    private $mailerInterface;
    private $security;

    public function __construct(MailerInterface $mailerInterface, Security $security)
    {
        $this->mailerInterface = $mailerInterface;
        $this->security = $security;
    }


    public function contact(Request $request, EntityManagerInterface $entityManager)
    {
        $mail = new Mail();
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager();
            $this->sendMail($mail);
            $mail->setExpediteur($this->security->getUser()->getUsername());
            $entityManager->persist($mail);
            $entityManager->flush();
            return $this->redirectToRoute('administration');
        } else {
            return $this->render('contact/contactAdmin.html.twig',
                ['form' => $form->createView(),
                ]);
        }
    }

    public function sendMail(Mail $mail)
    {
        $email = (new email())
            ->from($this->security->getUser()->getUsername())
            ->to($mail->getDestinataire())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($mail->getSubject())
            //->text('Sending emails is fun again!')
            ->html($mail->getContenu());
        $this->mailerInterface->send($email);
    }

    /**
     * @Route("/contact", name="contact", methods={"GET","POST"})
     */
    public function contactFront(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactFrontType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $contact->setLu(false);
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('contact/index.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/contact", name="contact_admin", methods={"GET"})
     */
    public function listecontact(ContactRepository $contactRepository, Request $request): Response
    {
        return $this->render('contact/contactAdmin.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/mailResponse/{id}", name="mailResponse", methods={"GET", "POST"})
     */
    public function repondreAUnContact($id, ContactRepository $contactRepository, Request $request)
    {
        $mail = new Mail();
        $form = $this->createForm(Mail1Type::class, $mail);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager();
            $mail->setDestinataire($contactRepository->find($id)->getEmail());
            $mail->setSubject("Réponse à votre demande");
            $this->sendMail($mail);
            $contact =  $contactRepository->find($id);
            $contact->setLu(1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();
            return $this->redirectToRoute('contact_admin');
        } else {
            return $this->render('mail/mailResponse.twig', [
                'mail' => $contactRepository->find($id),
                'form' => $form->createView()
            ]);
        }
    }

    /**
     * @Route("/admin/contact/{id}", name="contact_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Contact $contact): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contact->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('contact_admin');
    }
}

