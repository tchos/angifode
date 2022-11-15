<?php

namespace App\Controller;

use App\Entity\AgentDetache;
use App\Entity\Historique;
use App\Entity\Organismes;
use App\Form\DetachementType;
use App\Repository\AgentDetacheRepository;
use App\Repository\GradeRepository;
use App\Repository\OrganismesRepository;
use App\Services\BI;
use App\Services\Services;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;

/**
 * Require ROLE_USER for all the actions of this controller
 */
#[IsGranted('ROLE_USER')]
class AgentController extends AbstractController
{
    # Enregistrer un nouveau détachement
    #[Route('/agent', name: 'agent_detache_new')]
    public function detacher(EntityManagerInterface $manager, Request $request, Services $services,
                             OrganismesRepository $organismesRepository, GradeRepository $gradeRepository): Response
    {
        // utilisateur connecté
        $user = $this->getUser()->getUsername();
        // pour l'historisation de l'action
        $history = new Historique();
        // organisme de l'utilisateur connecté
        $organisme = $this->getUser()->getOrganisme()->getSigle();

        //entité AgentDetache à associer au formulaire de creation d'un nouveau détachement
        $detache = new AgentDetache();

        //Les users du MINFI ou alors les admin voyent tous les organismes
        if ($this->isGranted('ROLE_ADMIN') | $organisme === "MINFI")
            $organisme = "";

        $listeOrganisme = $organismesRepository->findBySigle($organisme);

        // constructeur de formulaire de creation d'un nouveau détachement
        $form = $this->createForm(DetachementType::class, $detache, ['organisme' => $listeOrganisme]);

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
            $grade = $gradeRepository->findOneBy(["libGrade" => $form->get("gradeDet")->getData()])->getCodeGrade();

            if ( $age < 17 )
            {
                // $form->get('dateNaissance') me donne accès au champ dateNaissance du formulaire
                $form->get('dateIntegration')->addError(new FormError("Le détaché ne peut être intégré avant 17 ans !"));
            }else {
                $detache->setGradeDet($grade)
                    ;

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

                return $this->redirectToRoute('agent_detache_list');
            }
        }
        return $this->render('agent/agent_detache.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    # Apporter des modifications à un détachement
    #[Route('/agent/{id}/edit', name: 'agent_detache_edit')]
    public function update (EntityManagerInterface $manager, Request $request, OrganismesRepository $organismesRepository,
                             AgentDetache $detache, GradeRepository $gradeRepository): Response
    {
        // utilisateur connecté
        $user = $this->getUser()->getUsername();
        // pour l'historisation de l'action
        $history = new Historique();
        // organisme de l'utilisateur connecté
        $organisme = $this->getUser()->getOrganisme()->getSigle();
        //Les users du MINFI ou alors les admin voyent tous les organismes
        if ($this->isGranted('ROLE_ADMIN') | $organisme === "MINFI")
            $organisme = "";

        $listeOrganisme = $organismesRepository->findBySigle($organisme);

        // constructeur de formulaire de creation d'un nouveau détachement
        $form = $this->createForm(DetachementType::class, $detache, ['organisme' => $listeOrganisme]);

        // handlerequest() permet de parcourir la requête et d'extraire les informations du formulaire
        $form->handleRequest($request);

        /**
         * Ayant extrait les infos saisies dans le formulaire,
         * on vérifie que le formulaire a été soumis et qu'il est valide
         */
        if($form->isSubmitted() && $form->isValid())
        {
            $age = $detache->getDateNaissance()->diff($detache->getDateIntegration())->format('%y');
            //$grade =

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

                return $this->redirectToRoute('agent_detache_list');
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
        if($this->getUser()->getOrganisme()->getSigle() === "MINFI" | $this->isGranted('ROLE_ADMIN'))
            $listeAgentDetaches = $repos->findAll();
        else
            $listeAgentDetaches = $repos->findBy(['organisme' => $this->getUser()->getOrganisme()]);

        return $this->render('agent/agent_detache_list.html.twig',[
            'listeAgentDetaches' => $listeAgentDetaches
        ]);
    }

    # Pour afficher la liste des détachés sur une année donnée
    #[Route('/agent/{year<\d+>?1999}', name: 'agent_detache_year')]
    public function listDetacheYear(String $year, BI $bi, Services $statistiques): Response
    {
        // 'nbUsers', 'nbOrganismes', 'nbAgentsDetaches'
        $stats = $statistiques->getStats();

        if($this->getUser()->getOrganisme()->getSigle() === "MINFI" | $this->isGranted('ROLE_ADMIN')){
            $listeAgentDetaches = $bi->getDetachesByYear($year);
        }else {
            // return $this->redirectToRoute(''); page 403 à développer.
        }

        return $this->render('agent/agent_detache_year.html.twig',[
            'listeAgentDetaches' => $listeAgentDetaches,
            'year' => $year,
            'stats' => $stats,
        ]);
    }
}
