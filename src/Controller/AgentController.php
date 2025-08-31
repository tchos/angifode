<?php

namespace App\Controller;

use App\Entity\AgentDetache;
use App\Entity\Decisions;
use App\Entity\FinDetachement;
use App\Entity\Historique;
use App\Entity\Organismes;
use App\Form\DetachementType;
use App\Form\FinDetachementType;
use App\Form\SearchAgentType;
use App\Repository\AgentDetacheRepository;
use App\Repository\BaremeRepository;
use App\Repository\GradeRepository;
use App\Repository\MinistereRepository;
use App\Repository\OrganismesRepository;
use App\Services\BI;
use App\Services\Services;
use Container2BVCigq\getMinistereRepositoryService;
use Doctrine\DBAL\Exception\ServerException;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Dompdf\Dompdf;
use Dompdf\Options;
use Sasedev\MpdfBundle\Factory\MpdfFactory;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Require ROLE_USER for all the actions of this controller
 */
#[IsGranted('ROLE_USER')]
class AgentController extends AbstractController
{
    # Enregistrer un nouveau détachement
    #[Route('/{_locale<%app.supported_locales%>}/agent', name: 'agent_detache_new')]
    public function detacher(EntityManagerInterface $manager, Request $request, Services $services, TranslatorInterface $translator,
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
            $codeGrade = $services->getCodeGradeByLibelleGrade($form->get("gradeDet")->getData());
            $sb = $services->getSB(
                                    $codeGrade[0]['codeGrade'],
                                    $form->get("classeDet")->getData(),
                                    $form->get("echelonDet")->getData()
            );

            if ( $age < 17 )
            {
                // $form->get('dateNaissance') me donne accès au champ dateNaissance du formulaire
                $form->get('dateIntegration')->addError(new FormError("Le détaché #[IsGranted('ROLE_USER')]ne peut être intégré avant 17 ans !"));
            } elseif ($codeGrade == null) {
                // $form->get('gradeDet') me donne accès au champ gradeDet du formulaire
                $form->get('gradeDet')->addError(new FormError("Le grade renseigné n'existe pas en base de données !"));
            } elseif ($sb == null) {
                // $form->get('echelonDet') me donne accès au champ echelonDet du formulaire
                $form->get('echelonDet')->addError(new FormError("Echelon inexistant pour la classe donnée !"));
            } else {
                $grade = $gradeRepository->findOneBy(["libGrade" => $form->get("gradeDet")->getData()]);
                $detache->setGradeDet($grade->getCodeGrade());

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
                $flash = $translator->trans("Le nouveau détachement a été enregistré avec succès !!!");
                $this->addFlash("success", $flash);

                return $this->redirectToRoute('agent_detache_list');
            }
        }
        return $this->render('agent/agent_detache.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    # Apporter des modifications à un détachement
    #[Route('/{_locale<%app.supported_locales%>}/agent/{id}/edit', name: 'agent_detache_edit')]
    public function update (EntityManagerInterface $manager, Request $request, OrganismesRepository $organismesRepository,
                             AgentDetache $detache, GradeRepository $gradeRepository, Services $services,
                            TranslatorInterface $translator): Response
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
        // On convertit le codeGrade en libelleGrade que l'on va afficher dans le formulaire
        $libelleGrade = $gradeRepository->findOneBy(["codeGrade" => $detache->getGradeDet()])->getLibGrade();
        $detache->setGradeDet($libelleGrade);

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
            //On récupère le code du grade .
            $codeGrade = $services->getCodeGradeByLibelleGrade($form->get("gradeDet")->getData());
            $sb = $services->getSB(
                $codeGrade[0]['codeGrade'],
                $form->get("classeDet")->getData(),
                $form->get("echelonDet")->getData()
            );

            if ( $age < 17 )
            {
                // $form->get('dateNaissance') me donne accès au champ dateNaissance du formulaire
                $form->get('dateIntegration')->addError(new FormError("Le détaché ne peut être intégré avant 17 ans !"));
            } elseif (empty($codeGrade)) {
                // $form->get('gradeDet') me donne accès au champ gradeDet du formulaire
                $form->get('gradeDet')->addError(new FormError("Grade inexistant en base de données !"));
            }  elseif ($sb == null) {
                // $form->get('echelonDet') me donne accès au champ echelonDet du formulaire
                $form->get('echelonDet')->addError(new FormError("Echelon inexistant pour la classe donnée !"));
            } else {
                $grade = $gradeRepository->findOneBy(["libGrade" => $form->get("gradeDet")->getData()]);
                $detache->setGradeDet($grade->getCodeGrade());
                //dd($detache->getGradeDet());
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
                $this->addFlash("warning",
                                $translator->trans("Les modifications apportées au détachement ont été enregistrés avec succès !!!"));

                return $this->redirectToRoute('agent_detache_list');
            }
        }

        return $this->render('agent/agent_detache_edit.html.twig', [
            'form' => $form->createView(),
            'detache' => $detache
        ]);
    }

    # Pour afficher la liste des détachés
    #[Route('/{_locale<%app.supported_locales%>}/agent/list', name: 'agent_detache_list')]
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
    #[Route('/{_locale<%app.supported_locales%>}/agent/{year<\d+>?1999}', name: 'agent_detache_year')]
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

    # Pour mettre fin au détachement de l'agent dans un organisme
    #[Route('/{_locale<%app.supported_locales%>}/agent/findetachement/{id}', name: 'fin_detachement')]
    public function finDetachement(EntityManagerInterface $manager, Request $request, AgentDetache $agentDetache,
                                   TranslatorInterface $translator): Response
    {
        // utilisateur connecté
        $user = $this->getUser()->getUsername();
        // pour l'historisation de l'action de fin de détachement
        $history = new Historique();
        //entité AgentDetache à associer au formulaire de fin de détachement
        $detache = $agentDetache;

        $finDetachement = new FinDetachement();

        // constructeur de formulaire de creation de fin de détachement
        $form = $this->createForm(FinDetachementType::class, $finDetachement);

        // handlerequest() permet de parcourir la requête et d'extraire les informations du formulaire
        $form->handleRequest($request);

        /**
         * Ayant extrait les infos saisies dans le formulaire,
         * on vérifie que le formulaire a été soumis et qu'il est valide
         */
        if($form->isSubmitted() && $form->isValid())
        {
            $dateFinDet = $form->get("dateFinDet")->getData();

            $detache->setDateFinDet($dateFinDet);

            $finDetachement->setAgentDetache($detache);

            $history->setTypeAction("CREATE")
                ->setAuteur($user)
                ->setNature("FIN DETACHEMENT")
                ->setClef($detache->getMatricule().' - '.$detache->getOrganisme()->getSigle())
                ->setDateAction(new \DateTime())
            ;
            // Persistence de l'entité AgentDetache
            $manager->persist($detache);
            $manager->persist($history);
            $manager->persist($finDetachement);
            $manager->flush();

            // Alerte succès de l'enregistrement d'un nouveau détachement
            $this->addFlash("success",
                            $translator->trans("Fin de détachement enregistré avec succès !!!") );

            return $this->redirectToRoute('agent_detache_list');
        }
        return $this->render('agent/fin_detache.html.twig', [
            'form' => $form->createView(),
            'detache' => $detache
        ]);
    }

    # Apporter des modifications à un détachement
    #[Route('/{_locale<%app.supported_locales%>}/agent/details/{id<\d+>}', name: 'agent_detache_details')]
    public function details (AgentDetache $agentDetache, MinistereRepository $ministereRepository,
                             GradeRepository $gradeRepository, Services $services): Response
    {
        $detache = $agentDetache;
        $gradeDet = $gradeRepository->findOneBy(['codeGrade' => $detache->getGradeDet()]);
        $ministere = $ministereRepository->findOneBy(['codeMinistere' => $detache->getMinistere()]);
        $indiceDet = $services->getIndice($detache->getGradeDet(), $detache->getClasseDet(), $detache->getEchelonDet());

        return $this->render('agent/details_detache.html.twig', [
            'agent' => $detache,
            'grade' => $gradeDet,
            'indiceDet' => $indiceDet,
            'ministere' => $ministere,
        ]);
    }

    # Exportation des données vers un fichier pdf
    #[Route('/{_locale<%app.supported_locales%>}/agent/pdf/details/{id<\d+>}', name: 'agent_detache_details_pdf')]
    public function detailsPdf (AgentDetache $agentDetache, MinistereRepository $ministereRepository,
                             GradeRepository $gradeRepository, Services $services, MpdfFactory $mpdfFactory): Response
    {
        $detache = $agentDetache;
        $gradeDet = $gradeRepository->findOneBy(['codeGrade' => $detache->getGradeDet()]);
        $ministere = $ministereRepository->findOneBy(['codeMinistere' => $detache->getMinistere()]);
        $indiceDet = $services->getIndice($detache->getGradeDet(), $detache->getClasseDet(), $detache->getEchelonDet());

        //Options du pdf
        $pdfOptions = new Options();
        //Police par défaut
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->setIsRemoteEnabled(true);

        // On instancie domPdf
        $domPdf = new Dompdf($pdfOptions);
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $domPdf->setHttpContext($context);

        // Page twig
        $html = $this->renderView('agent/details_detache_pdf.html.twig', [
            'agent' => $detache,
            'grade' => $gradeDet,
            'indiceDet' => $indiceDet,
            'ministere' => $ministere,
        ]);

        $domPdf->loadHtml($html);
        $domPdf->setPaper('A4', 'portrait');
        $domPdf->render();

        // On envoie le fichier au navigateur
        $domPdf->stream('file.pdf', ['Attachement' => true]);

        return new Response();
        /**  Ne marche pas encore
        $mpdf = $mpdfFactory->createMpdfObject([
            'mode' => 'utf-8',
            'format' => 'A4',
            'orientation' => 'P'
        ]);
        $mpdf->WriteHTML($this->renderView('agent/details_detache_pdf.html.twig',[
            'agent' => $detache,
            'grade' => $gradeDet,
            'indiceDet' => $indiceDet,
            'ministere' => $ministere,
        ]));
        return $mpdfFactory->createDownloadResponse($mpdf, 'file.pdf', 'I'); */

        /**
        $html = $this->renderView('agent/details_detache_pdf.html.twig', [
            'agent' => $detache,
            'grade' => $gradeDet,
            'indiceDet' => $indiceDet,
            'ministere' => $ministere,
        ]);

        return new PdfResponse($knpSnapyPdf->getOutputFromHtml($html),
            '/home/tchos/Documents/projets/symfony/angifode/public/asset/snappy/file.pdf');
         */
    }

    # Supprimer un détachement en BD
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/{_locale<%app.supported_locales%>}/agent/{id}/delete', name: 'delete_detache')]
    public function delete(Request $request, AgentDetache $agentDetache, EntityManagerInterface $entityManager,
                           TranslatorInterface $translator): Response
    {
        $history = new Historique();

        $history->setTypeAction("DELETE")
            ->setAuteur($this->getUser()->getUsername())
            ->setNature("SUPPRESION DETACHEMENT")
            ->setClef($agentDetache->getMatricule().' - '.$agentDetache->getOrganisme()->getSigle())
            ->setDateAction(new \DateTime())
        ;

        $entityManager->persist($history);
        $entityManager->remove($agentDetache);
        $entityManager->flush();
        $this->addFlash("success", $translator->trans("Suppression du détachement effectué avec avec succès !!!") );

        return $this->redirectToRoute('agent_detache_list');
    }

    # Recherche un agent public à partir de son nom ou son matricul
    #[Route('/{_locale<%app.supported_locales%>}/agent/search', name: 'search_agent')]
    public function searcheAgent(Request $request, BI $bi, Services $statistiques, TranslatorInterface $translator): Response
    {
        $agents = null; // Variable qui va contenir le resultat de la recherche

        // constructeur du formulaire qui va capter les informations de l'agent recherché
        $form = $this->createForm(SearchAgentType::class);

        // handlerequest() permet de parcourir la requête et d'extraire les informations du formulaire
        $form->handleRequest($request);

        /**
         * Ayant extrait les infos saisies dans le formulaire,
         * on vérifie que le formulaire a été soumis et qu'il est valide
         */
        if($form->isSubmitted() && $form->isValid())
        {
            // Récupérer le matricule et/ou le numero d'ESD saisis dans le formulaire
            $donnees = $form->getData();
            $cherche = $donnees['recherche'];

            // Recherche dans le BD des ESD lies aux infos saisis
            $agents = $bi->searchAgentByNameOrMatricule($cherche);
            //dd($agents);

            // Si l'on ne trouve rien on affiche un message d'Agent non trouve
            if(!$agents) {
                $this->addFlash("danger",
                    $translator->trans("Erreur !!!
                        Il n'existe aucun agent(s) public(s) avec pour nom et/ou matricule "
                        .$cherche." dans le fichier solde.")
                );
            }
        }

        return $this->render('agent/search_agent.html.twig', [
            'form' => $form->createView(),
            'agents' => $agents,
        ]);
    }
}
