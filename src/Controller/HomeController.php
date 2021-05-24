<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="home_")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("", name="browse")
     */
    public function browse(): Response
    {
        return $this->render('home/browse.html.twig', [
            'current_page' => 'home',
        ]);
    }
}
