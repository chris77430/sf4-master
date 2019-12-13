<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function index(Request $request,UserPasswordEncoderInterface $encoder, EntityManagerInterface $em,MailerInterface $mail)
    {
        $registration_Form = $this->createForm(UserRegistrationFormType::class);
        $registration_Form->handleRequest($request);

        if ($registration_Form->isSubmitted()&& $registration_Form->isValid()){
            $user= $registration_Form->getData();
            $password=$user->getPassword();
            $encoded=$encoder->encodePassword($user,$password);
            $user   ->setPassword($encoded)
                    ->setIsConfirmed(false)
                    ->renewToken();
            $em->persist($user);
            $em->flush();
            $mailer=new EmailController();


            $mailer->sendEmail($mail,$user);

-

            $this->addFlash('success', 'Inscription reussi.Veuillez consulter votre boite email pour confirmer votre adresse email');
        }
        return $this->render('user/registration.html.twig', [
            'registration_form' => $registration_Form->createView()
        ]);
    }

}
