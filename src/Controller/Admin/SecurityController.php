<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
            $lastUserName = $authenticationUtils->getLastUsername();
            $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('admin/security/login.html.twig', [
            "lastUserName" => $lastUserName,
            'error' => $error,
        ]);
    }
}
