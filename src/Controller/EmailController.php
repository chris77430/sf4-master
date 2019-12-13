<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    /**
     * @Route("/user_confirmation/{id}/{token}", name="user_confirmation")
     */
    public function index()
    {


        return $this->render('emails/signup.html.twig');
    }
    public function sendEmail(MailerInterface $mailer,User $user)
    {
        $link="localhost:8000/user_confirmation/{$user->getId()}/{$user->getSecurityToken()}";

        $email = (new Email())
            ->from('bourdonne.chris@gmail.com')
            ->to($user->getEmail())
            ->subject('Validation inscription')
            ->html('Vous trouverez ci-dessous  le lien permettant de validé votre adresse mail')
            ->html( '<a href='.$link.'>'.$link.'<a>');


        $mailer->send($email);
    }
}
