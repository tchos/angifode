<?php

namespace App\Controller;

use App\Entity\AgentDetache;
use App\Entity\Historique;
use App\Form\DetachementType;
use App\Repository\AgentDetacheRepository;
use App\Repository\OrganismesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;

class AgentController extends AbstractController
{
    # Enregistrer un nouveau détachement
    #[Route('/agent', name: 'agent_detache_new')]
    #[IsGranted("ROLE_USER")]
    public function detacher(EntityManagerInterface $manager, Request $request): Response
    {
        $msg = null;
        $good = null;

        // utilisateur connecté
        $user = $this->getUser()->getUsername();
        // pour l'historisation de l'action
        $history = new Historique();

        //entité AgentDetache à associer au formulaire de creation d'un nouveau détachement
        $detache = new AgentDetache();

        // constructeur de formulaire de creation d'un nouveau détachement
        $form = $this->createForm(DetachementType::class, $detache);

        // handlerequest() permet de parcourir la requête et d'extraire les informations du formulaire
        $form->handleRequest($request);

        /**
         * Ayant extrait les infos saisies dans le formulaire,
         * on vérifie que le formulaire a été soumis et qu'il est valide
         */
        // On ne peut être intégré avant 17 ans
        if($form->isSubmitted() && $form->isValid())
        {
            $age = $detache->getDateNaissance()->diff($detache->getDateIntegration())->format('%y');

            if ( $age < 17 )
            {
                // $form->get('dateNaissance') me donne accès au champ dateNaissance du formulaire
                $form->get('dateIntegration')->addError(new FormError("Le détaché ne peut être intégré avant 17 ans !"));
            }else {
                $history->setTypeAction("CREATE")
                    ->setAuteur($user)
                    ->setNature("AGENT_DETACHE")
                    ->setClef($form->get('matricule')->getData())
                    ->setDateAction(new \DateTime())
                ;
                // Persistence de l'entité AgentDetache
                $manager->persist($detache);
                $manager->persist($history);
                $manager->flush();

                // Alerte succès de l'enregistrement d'un nouveau détachement
                $this->addFlash("success","Le nouveau détachement a été enregistré avec succès !!!");

                return $this->redirectToRoute('agent_new');
            }
        }
        return $this->render('agent/agent_detache.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    # Apporter des modifications à un détachement
    #[Route('/agent/{id}/edit', name: 'agent_detache_edit')]
    #[IsGranted("ROLE_USER")]
    public function update (EntityManagerInterface $manager, Request $request,
                             AgentDetache $detache): Response
    {
        // utilisateur connecté
        $user = $this->getUser()->getUsername();
        // pour l'historisation de l'action
        $history = new Historique();

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
            $age = $detache->getDateNaissance()->diff($detache->getDateIntegration())->format('%y');

            if ( $age < 17 )
            {
                // $form->get('dateNaissance') me donne accès au champ dateNaissance du formulaire
                $form->get('dateIntegration')->addError(new FormError("Le détaché ne peut être intégré avant 17 ans !"));
            }else {
                $history->setTypeAction("UPDATE")
                    ->setAuteur($user)
                    ->setNature("AGENT_DETACHE")
                    ->setClef($form->get('matricule')->getData())
                    ->setDateAction(new \DateTime())
                ;
                // Persistence de l'entité AgentDetache
                $manager->persist($detache);
                $manager->persist($history);
                $manager->flush();

                // Alerte succès de la mise à jour du détachement
                $this->addFlash("warning","Les modifications apportées au détachement ont été enregistrés avec succès !!!");

                return $this->redirectToRoute('agent_new');
            }
        }

        return $this->render('agent/agent_detache_edit.html.twig', [
            'form' => $form->createView(),
            'detache' => $detache
        ]);
    }

    # Pour afficher la liste des détachés
    #[Route('/agent/list', name: 'agent_detache_list')]
    public function list(EntityManagerInterface $manager, Request $request, AgentDetacheRepository $repos): Response
    {
        $listeAgentDetaches = $repos->findAll();

        return $this->render('agent/agent_detache_list.html.twig',[
            'listeAgentDetaches' => $listeAgentDetaches
        ]);
    }
}
