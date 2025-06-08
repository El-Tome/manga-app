<?php

namespace App\Controller;

use App\Form\LoginForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             // return $this->redirectToRoute('app_home');
         }

        // Créer le formulaire
        $form = $this->createForm(LoginForm::class);

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Pré-remplir le champ email avec la dernière valeur saisie
        if ($lastUsername) {
            $form->get('email')->setData($lastUsername);
        }

        return $this->render('security/login.html.twig', [
            'loginForm' => $form->createView(),
            'error' => $error
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
