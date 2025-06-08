<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationForm;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    public function __construct(
        private readonly EmailVerifier  $emailVerifier,
        private readonly UserRepository $userRepository
    )
    {}

    #[Route('/register', name: 'app_register')]
    public function register(
        Request                     $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface      $entityManager
    ): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // encode the plain password
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            $entityManager->persist($user);
            $entityManager->flush();

            $request->getSession()->set('verify_user_id', $user->getId());

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('test@test.com', 'testMailer'))
                    ->to((string) $user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            return $this->redirectToRoute('app_please_verify_email');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request): Response
    {
       $id = $request->get('id');

    if (!$id) {
        $this->addFlash('verify_email_error', 'Invalid link.');
        return $this->redirectToRoute('app_register');
    }

    $user = $this->userRepository->find($id);

    if (!$user) {
        $this->addFlash('verify_email_error', 'User not found.');
        return $this->redirectToRoute('app_register');
    }

        $this->emailVerifier->handleEmailConfirmation($request, $user);

        $this->addFlash('success', 'Your email address has been verified.');
        $request->getSession()->remove('verify_user_id');

        return $this->redirectToRoute('app_login');
    }

    #[Route('/check/email', name: 'app_please_verify_email')]
    public function verifyEmail(Request $request): Response
    {
        $id = $request->getSession()->get('verify_user_id');

        if (!$id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $this->userRepository->find($id);

        if (!$user) {
            return $this->redirectToRoute('app_register');
        }

        if ($user->isVerified()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/verify_email.html.twig', [
            'user' => $user,
        ]);
    }
}
