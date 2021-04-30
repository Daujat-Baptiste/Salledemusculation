<?php

namespace App\Controller;

use App\Entity\Mail;
use App\Form\Mail1Type;
use App\Form\MailType;
use App\Repository\MailRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("admin/mail")
 */
class MailController extends AbstractController
{

    private MailerInterface $mailerInterface;

    public function __construct(MailerInterface $mailerInterface)
    {
        $this->mailerInterface = $mailerInterface;
    }

    /**
     * @Route("/", name="mail_index", methods={"GET"})
     */
    public function index(MailRepository $mailRepository): Response
    {
        return $this->render('mail/index.html.twig', [
            'mails' => $mailRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="mail_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $mail = new Mail();
        $form = $this->createForm(MailType::class, $mail);
        $form->handleRequest($request);
        $users = $userRepository->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($users as $user) {
                $mail->setExpediteur("baptiste.daujat@sfr.fr");
                $mail->setDestinataire($user->getEmail());
                try {
                    $this->sendMail($mail);
                } catch (\Exception $e) {
                    var_dump($e);
                }
            }

            return $this->redirectToRoute('mail_index');
        }

        return $this->render('mail/new.html.twig', [
            'mail' => $mail,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mail_show", methods={"GET"})
     */
    public function show(Mail $mail): Response
    {
        return $this->render('mail/show.html.twig', [
            'mail' => $mail,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="mail_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Mail $mail): Response
    {
        $form = $this->createForm(Mail1Type::class, $mail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mail_index');
        }

        return $this->render('mail/edit.html.twig', [
            'mail' => $mail,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="mail_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Mail $mail): Response
    {
        if ($this->isCsrfTokenValid('delete' . $mail->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($mail);
            $entityManager->flush();
        }

        return $this->redirectToRoute('mail_index');
    }

    public function sendMail(Mail $mail)
    {
        $email = (new email())
            ->from($mail->getExpediteur())
            ->to($mail->getDestinataire())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($mail->getSubject())
            //->text('Sending emails is fun again!')
            ->html($mail->getContenu());
        try {
            $this->mailerInterface->send($email);
        } catch (TransportExceptionInterface $e) {
           var_dump($e);
        }
    }
}
