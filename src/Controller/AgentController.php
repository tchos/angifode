<?php

namespace App\Controller;

use App\Entity\AgentDetache;
use App\Form\DetachementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgentController extends AbstractController
{
    #[Route('/agent', name: 'agent_new')]
    public function detacher(EntityManagerInterface $manager, Request $request): Response
    {
        //entité AgentDetache à associer au formulaire de creation d'un nouveau détachement
        $detache = new AgentDetache();

        // constructeur de formulaire de creation d'un nouveau détachement
        $form = $this->createForm(DetachementType::class, $detache);

        // handlerequest() permet de parcourir la requête et d'extraire les informations du formulaire
        $form->handleRequest($request);

        /**
         * Ayant extrait les infos saisies dans le formulaire,
         * on vérifie que le formulaire a été soumis et qu'il est valide
         * ->add('dateFinDet')
        ->add('dateCreation')
         */
        if($form->isSubmitted() && $form->isValid())
        {
            // Persistence de l'entité Organismes
            $manager->persist($detache);
            $manager->flush();

            // Alerte succès de l'enregistrement de l'acte de décès
            $this->addFlash("primary", "Nouveau détachement enregistré avec succès !!!");

            return $this->redirectToRoute('agent_new');
        }
        return $this->render('agent/agent_detache.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
