<?php

namespace App\Controller;

use App\Entity\Organismes;
use App\Form\OrganismesType;
use App\Repository\OrganismesRepository;
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
            $this->addFlash("primary", "Organisme créé avec succès !");

            return $this->redirectToRoute('create_organisme');
        }

        return $this->render('organismes/orga_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet de modifier les informations sur un organisme
     *
     * @Route("organisme/{id}/edit", name="organisme_edit")
     *
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Organismes $organisme
     * @return Response
     */
    public function edit(EntityManagerInterface $manager, Request $request, Organismes $organisme): Response
    {
        // constructeur de formulaire de saisie des actes de décès
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
            $this->addFlash("warning", "Organisme modifié avec succès !");

            return $this->redirectToRoute('organisme_list');
        }

        return $this->render('organismes/orga_edit.html.twig', [
            'form' => $form->createView(),
            'organisme' => $organisme
        ]);
    }

    /**
     * Permet de lister les organismes existant
     *
     * @Route("organisme/list", name="organisme_list")
     *
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Organismes $organisme
     * @return Response
     */
    public function list(EntityManagerInterface $manager, Request $request, OrganismesRepository $repos): Response
    {
        $listeOrganismes = $repos->findAll();
        return $this->render('organismes/orga_list.html.twig',[
            'listeOrganismes' => $listeOrganismes
        ]);
    }
}
