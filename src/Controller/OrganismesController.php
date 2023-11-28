<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Entity\Organismes;
use App\Entity\User;
use App\Form\OrganismesType;
use App\Repository\AgentDetacheRepository;
use App\Repository\OrganismesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Require ROLE_USER for all the actions of this controller
 */
#[IsGranted('ROLE_ADMIN')]
class OrganismesController extends AbstractController
{
    #[Route('/{_locale<%app.supported_locales%>}/organisme', name: 'create_organisme')]
    public function index(EntityManagerInterface $manager, Request $request, TranslatorInterface $translator): Response
    {
        // utilisateur connecté
        $user = $this->getUser()->getUsername();
        // pour l'historisation de l'action
        $history = new Historique();

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
            // Historique pour la créaton de l'organisme
            $history->setTypeAction("CREATE")
                    ->setAuteur($user)
                    ->setNature("ORGANISME")
                    ->setClef($form->get('sigle')->getData())
                    ->setDateAction(new \DateTime())
            ;

            // Persistence de l'entité Organismes et Historique
            $manager->persist($organisme);
            $manager->persist($history);
            $manager->flush();

            // Alerte succès de l'enregistrement d'un nouvel organisme
            $this->addFlash("success", $translator->trans("Organisme créé avec succès !"));

            return $this->redirectToRoute('organisme_list');
        }

        return $this->render('organismes/orga_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de modifier les informations sur un organisme
     *
     * @Route("/{_locale<%app.supported_locales%>}/organisme/{id}/edit", name="organisme_edit")
     *
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @param Organismes $organisme
     * @return Response
     */
    public function edit(EntityManagerInterface $manager, Request $request, Organismes $organisme,
                            TranslatorInterface $translator): Response
    {
        // utilisateur connecté
        $user = $this->getUser()->getUsername();
        // pour l'historisation de l'action
        $history = new Historique();

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
            $history->setTypeAction("UPDATE")
                ->setAuteur($user)
                ->setNature("ORGANISME")
                ->setClef($form->get('sigle')->getData())
                ->setDateAction(new \DateTime())
            ;
            // Persistence de l'entité Organismes
            $manager->persist($organisme);
            $manager->persist($history);
            $manager->flush();

            // Alerte succès de la mise à jour des informations sur un organisme
            $this->addFlash("warning", $translator->trans("Organisme modifié avec succès !"));

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
     * @Route("/{_locale<%app.supported_locales%>}/organisme/list", name="organisme_list")
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

    # Pour afficher la liste des détachés pour un organisme donné.
    #[Route('/organisme/{id}/detaches', name: 'show_list_detache')]
    public function detachesOrganisme(Organismes $organisme): Response
    {
        if($this->getUser()->getOrganisme()->getSigle() === "MINFI" | $this->isGranted('ROLE_ADMIN')){
            $listeAgentDetaches = $organisme->getAgentDetaches();
        }else{
            // return $this->redirectToRoute(''); page 403 à développer.
        }

        return $this->render('agent/agent_detache_list.html.twig',[
            'listeAgentDetaches' => $listeAgentDetaches
        ]);
    }
}
