<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/checkRole', name: 'app_checkAdmin')]
    public function checkAdmin(): Response
    {
        $user = $this->getUser();
        if ($user && in_array('ROLE_ADMIN', $user->getRoles())) {
            return $this->redirectToRoute('admin');
        } else {
            return $this->redirectToRoute('pokemon_list',["username"=>$user->getUserIdentifier()]);
        }
    }
}