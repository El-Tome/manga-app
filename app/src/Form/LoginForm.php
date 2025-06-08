<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Your email'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'please enter your email',
                    ]),
                    new Email([
                        'message' => 'Please enter a valid email',
                    ])
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Your password'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'please enter your password',
                    ]),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Login',
                'attr' => [
                    'class' => 'btn btn-primary btn-lg'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
