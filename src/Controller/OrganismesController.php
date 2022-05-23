<?php

namespace App\Controller;

use App\Entity\Organismes;
use App\Form\OrganismesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrganismesController extends AbstractController
{
    #[Route('/organisme', name: 'create_organisme')]
    public function index(EntityManagerInterface $manager, Request $request): Response
    {
        //entité organisme à associer au formulaire de creation d'un organisme
        $organisme = new Organismes();

        // constructeur de formulaire de creation d'un organisme
        $form = $this->createForm(OrganismesType::class, $organisme);

        // handlerequest() permet de parcourir la requête et d'extraire les informations du formulaire
        $form->handleRequest($request);

        /**
         * Ayant extrait les infos saisies dans le formulaire, 
         * on vérifie que le formulaire a été soumis et qu'il est valide
         */
        if($form->isSubmitted() && $form->isValid())
        {
            // Persistence de l'entité Organismes
            $manager->persist($organisme);
            $manager->flush();

            // Alerte succès de l'enregistrement de l'acte de décès
            $this->addFlash("success", "Organisme créé avec succès !");

            return $this->redirectToRoute('create_organisme');
        }

        return $this->render('organismes/addOrga.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
