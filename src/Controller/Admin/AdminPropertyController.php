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
            'current_page' => 'administration',
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
            $entityManager->flush();
            $this->addFlash('success', 'Bien modifié avec succès');
            return $this->redirectToRoute('admin_property_browse');
        }

        return $this->render('admin/property/edit.html.twig', [
            'property'=> $property,
            'form'=> $form->createView(),
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function add(Request $request): Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($property);
            $entityManager->flush();
            $this->addFlash('success', 'Bien ajouté avec succès');

            return $this->redirectToRoute('admin_property_browse');
        }

        return $this->render('admin/property/add.html.twig', [
            'property'=> $property,
            'form'=> $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", requirements={"id"="\d+"}, methods={"DELETE"})
     */
    public function delete(Property $property, Request $request): Response
    {
        $token = $request->request->get('_token');
        if ($this->isCsrfTokenValid('delete' . $property->getId() , $token)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($property);
            $em->flush();
            $this->addFlash('success', 'Bien supprimé avec succès');

            return $this->redirectToRoute('admin_property_browse');
        }
        // Si le token n'est pas valide, on lance une exception Access Denied
        throw $this->createAccessDeniedException('Le token n\'est pas valide.');
    }
}
