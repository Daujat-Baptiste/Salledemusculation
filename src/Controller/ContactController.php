<?php

namespace App\Controller;

use App\Entity\Mail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Form\MailType;
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
     * @Route("/contact", name="contact")
     */
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
    }
}
