<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/property", name="property_")
 */
class PropertyController extends AbstractController
{
    /**
     * @Route("/browse", name="browse")
     */
    public function browse(): Response
    {
        return $this->render('property/browse.html.twig', [
        ]);
    }
}
