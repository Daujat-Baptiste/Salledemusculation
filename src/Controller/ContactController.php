<?php

namespace App\Controller;

<<<<<<< HEAD
use App\Entity\Mail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Form\MailType;
=======
use App\Entity\Contact;
use App\Form\ContactFrontType;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
>>>>>>> 0e02568d5387ab7e53a34316600dd9747b9466f5
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    private $mailerInterface;
    private $security;

    public function __construct(MailerInterface $mailerInterface, Security $security)
    {
        $this->mailerInterface = $mailerInterface;
        $this->security = $security;
    }

    /**
     * @Route("/contact", name="contact", methods={"GET","POST"})
     */
<<<<<<< HEAD
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
            return $this->render('contact/index.html.twig',
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
=======
    public function contact(Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactFrontType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
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
     * @Route("/admin/contact", name="contact_admin", methods={"GET","POST"})
     */
    public function listecontact(ContactRepository $contactRepository, Request $request): Response
    {

        return $this->render('contact/contactAdmin.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
>>>>>>> 0e02568d5387ab7e53a34316600dd9747b9466f5
    }
}
