<?php

namespace App\Controller;

use App\Entity\AgentDetache;
use App\Form\DetachementType;
use App\Repository\AgentDetacheRepository;
use App\Repository\OrganismesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AgentController extends AbstractController
{
    # Enregistrer un nouveau détachement
    #[Route('/agent', name: 'agent_new')]
    public function detacher(EntityManagerInterface $manager, Request $request,
                             OrganismesRepository $reposOrga): Response
    {
        //entité AgentDetache à associer au formulaire de creation d'un nouveau détachement
        $detache = new AgentDetache();

        // constructeur de formulaire de creation d'un nouveau détachement
        $form = $this->createForm(DetachementType::class, $detache);

        // handlerequest() permet de parcourir la requête et d'extraire les informations du formulaire
        $form->handleRequest($request);
        //$organisme = $detache->getOrganisme();

        /**
         * Ayant extrait les infos saisies dans le formulaire,
         * on vérifie que le formulaire a été soumis et qu'il est valide
         */
        if($form->isSubmitted() && $form->isValid())
        {
            $orga = $request->get('detachement')['organisme'];
            // Pour gérer la relation ManyToMany avec Organisme et écrire dans la table agent_detache_organismes
            $organisme = $reposOrga->find($orga);
            $organisme->addAgentDetach($detache);
            $detache->addOrganisme($organisme);

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

    # Apporter des modifications à un détachement
    #[Route('/agent/{id}/edit', name: 'agent_edit')]
    public function update (EntityManagerInterface $manager, Request $request,
                             AgentDetache $detache, OrganismesRepository $reposOrga): Response
    {
        // Remove l'ancien organisme
        $ancienOrganisme = $detache->getOrganisme()->getValues('1')['0'];
        $idAncienOrganisme = $reposOrga->find($ancienOrganisme);
        $detache->removeOrganisme($idAncienOrganisme);

        // constructeur de formulaire de creation d'un nouveau détachement
        $form = $this->createForm(DetachementType::class, $detache);

        // handlerequest() permet de parcourir la requête et d'extraire les informations du formulaire
        $form->handleRequest($request);

        /**
         * Ayant extrait les infos saisies dans le formulaire,
         * on vérifie que le formulaire a été soumis et qu'il est valide
         */
        if($form->isSubmitted() && $form->isValid())
        {
            $orga = $request->get('detachement')['organisme'];
            // Pour gérer la relation ManyToMany avec Organisme et écrire dans la table agent_detache_organismes
            $organisme = $reposOrga->find($orga);
            $organisme->addAgentDetach($detache);
            $detache->addOrganisme($organisme);

            // Persistence de l'entité Organismes
            $manager->persist($detache);
            $manager->flush();

            // Alerte succès de l'enregistrement de l'acte de décès
            $this->addFlash("warning", "Nouveau détachement enregistré avec succès !!!");

            return $this->redirectToRoute('agent_new');
        }

        return $this->render('agent/agent_detache_edit.html.twig', [
            'form' => $form->createView(),
            'detache' => $detache
        ]);
    }
}
