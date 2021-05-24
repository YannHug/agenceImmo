<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/property", name="admin_property_")
 */
class AdminPropertyController extends AbstractController
{
    /**
     * @Route("/", name="browse")
     */
    public function browse(PropertyRepository $properties): Response
    {
        return $this->render('admin/property/browse.html.twig', [
            'properties'=> $properties->findAll()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit", requirements={"id"="\d+"})
     */
    public function edit(Property $property, Request $request): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($property);
            $entityManager->flush();

            return $this->redirectToRoute('admin_property_browse');
        }

        return $this->render('admin/property/edit.html.twig', [
            'property'=> $property,
            'form'=> $form->createView(),
        ]);
    }
}
