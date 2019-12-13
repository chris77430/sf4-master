<?php

namespace App\Form;

use App\Entity\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use Symfony\Component\Validator\Constraints\Regex;

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',RepeatedType::class,[
                'type'=>EmailType::class,
                'invalid_message'=>'Les adresses email doivent être identiques',
                    'options'=>['attr'=>['class'=>'email-field']],
                    'required'=>true,
                    'first_options'=>['label'=>'Email'],
                    'second_options'=>['label'=>'Confirmation email'],
                    'constraints' => [
        new NotBlank(['message' => 'Veuillez entrer un email.']),
        new Email(['message' => 'Veuillez rentrer une adresse valide.'])]]
                                                            )

            ->add('Password', PasswordType::class, [



                'constraints' => [

                    new NotBlank([

                        'message' => 'entrer un mot de passe'

                    ]),

                    new Length([

                        'min' => 5,

                        'minMessage' => 'mot de passe trop court'

                    ])

                ]

            ])
            ->add('pseudo',TextType::class,[
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez indiquer un pseudo.']),
                    new Regex([
                        'pattern' => '/^[a-z0-9-_]+$/i',
                        'message' => 'Le pseudo ne peut contenir que des caractères alphanumériques.'
                    ])
            ]])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
