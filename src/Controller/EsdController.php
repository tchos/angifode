<?php

namespace App\Controller;

use App\Classe\Esd;
use App\Entity\AgentDetache;
use App\Entity\Historique;
use App\Entity\Organismes;
use App\Entity\TypeBareme;
use App\Form\EsdType;
use App\Form\ReversementType;
use App\Repository\BaremeRepository;
use App\Repository\OrganismesRepository;
use App\Repository\TypeBaremeRepository;
use App\Services\PDFService;
use App\Services\Services;
use FontLib\Table\Type\name;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;

/**
 * Require ROLE_USER for all the actions of this controller
 */
#[IsGranted('ROLE_USER')]
class EsdController extends AbstractController
{
    #[Route('/esd/{id}', name: 'esd_evaluate')]
    public function index(Services $services, Organismes $organisme, Request $request): Response
    {
        // utilisateur connecté
        $user = $this->getUser();
        // pour l'historisation de l'action
        $history = new Historique();

        $esd = new Esd();

        // constructeur du formulaire qui va capter les dates de début et de fin
        $form = $this->createForm(EsdType::class, $esd);

        // handlerequest() permet de parcourir la requête et d'extraire les informations du formulaire
        $form->handleRequest($request);

        /**
         * Ayant extrait les infos saisies dans le formulaire,
         * on vérifie que le formulaire a été soumis et qu'il est valide
         */
        if($form->isSubmitted() && $form->isValid())
        {
            //Liste des agents détachés au sein de l'organisme .
            $agents = $organisme->getAgentDetaches()->toArray();

            // Tableau qui contient les id des agents détachés au sein de l'organisme
            $id_agent = [];
            // tableau: matricule => somme à reverser
            $sar_organisme = [];
            $dataCotis = [];

            for ($i = 0; $i < count($agents); $i++){

                $dateDebut = $form->get('dateDebut')->getData();
                $dateFin = $form->get('dateFin')->getData();
                $vraiDateDebut = $dateDebut;
                $vraiDateFin = $dateFin;

                $dateIntegration = $agents[$i]->getDateIntegration();
                $dateDet = $agents[$i]->getDateDet();
                $dateFinDet = $agents[$i]->getDateFinDet();
                $gradeDet = $agents[$i]->getGradeDet();
                $classeDet = $agents[$i]->getClasseDet();
                $echelonDet = $agents[$i]->getEchelonDet();
                $indiceDet = $services->getIndice($gradeDet, $classeDet, $echelonDet);

                // cotisations reversées pour l'agent sur la période définie.
                $dataCotis[] = $services->getTotalCotisations($agents[$i], $vraiDateDebut, $vraiDateFin);
                // on stocke l'ID de l'agent détaché qui va nous aider pour afficher les détails de l'évaluation de son ESD
                $id_agent[] = $agents[$i]->getId();
                $grade_agent[] = $agents[$i]->getGradeDet();

                if($vraiDateFin <= $dateDet)
                {
                    $dataEsd = [];
                    $detailsEsdAgent["dateDebut"] = $vraiDateDebut;
                    $detailsEsdAgent["dateFin"] = $vraiDateFin;
                    $detailsEsdAgent["sb"] = 0;
                    $detailsEsdAgent["partSalariale"] = 0;
                    $detailsEsdAgent["partPatronale"] = 0;
                    $detailsEsdAgent["sar"] = 0;
                    if($gradeDet >= "60000" && $gradeDet < "62000") {
                        $detailsEsdAgent["echelon"] = $echelon;
                    } else {
                        $detailsEsdAgent["indice"] = $indiceDet;
                    }
                    $dataEsd[] = $detailsEsdAgent;
                    $sar_organisme[$agents[$i]->getNoms() . " (" . $agents[$i]->getMatricule() . ")"] = $dataEsd;
                }
                else {
                    //Si la date de début est inférieure à la date de détachement, la date de début sera la date de détachement
                    if ($dateDet >= $vraiDateDebut && $dateDet <= $vraiDateFin){
                        $dateDebut = $dateDet;
                    }

                    //Si la date de fin est supérieure à la date de fin de détachement, la date de fin sera la date de fin de détachement
                    if ($dateFinDet > date_create("0001-01-01") && $dateFinDet <= date_create(date("Y-m-d"))){
                        if ($dateFinDet < $vraiDateFin){
                            $dateFin = $dateFinDet;
                        }
                    }

                    //Somme à reverser selon que l'agent détaché soit fonctionnnaire ou du code du travail
                    if($gradeDet >= "60000" && $gradeDet < "62000") {
                        $first_echelon = $services->getFirstEchelon($gradeDet, $echelonDet, $dateIntegration, $dateDebut, $dateDet);
                        // $sar = somme à reverser pour un agent détatché du code du travail
                        $sar = $services->getSommeAReverserCT($dateDebut, $dateFin, $first_echelon, $gradeDet, $dateIntegration, $dateDet);
                        $sar_organisme[$agents[$i]->getNoms() . " (" . $agents[$i]->getMatricule() . ")"] = $sar;

                    } else {
                        //$first_indice = $services->getFirstIndice("42120", 665, date_create("1995-07-21"), $dateDebut, $dateDet);
                        $first_indice = $services->getFirstIndice($gradeDet, $indiceDet, $dateIntegration, $dateDebut, $dateDet);
                        // $sar = somme à reverser pour un agent détatché fonction
                        $sar = $services->getSommeAReverserFC($dateDebut, $dateFin, $first_indice, $gradeDet, $dateIntegration, $dateDet);
                        $sar_organisme[$agents[$i]->getNoms() . " (" . $agents[$i]->getMatricule() . ")"] = $sar;
                        //dd($sar_organisme, $sar);
                    }
                }
            }

            //$sar = $services->getSommeAReverser($dateDebut, $dateFin, 420, "42210", date_create("1995-11-01"));
            $total_sar_organisme = 0;
            $dataSar = [];
            //dd($sar_organisme);

            foreach ($sar_organisme as $key => $value){
                $totalSar = 0;
                for($i = 0; $i < count($value); $i++) {
                    $totalSar += $value[$i]["sar"];
                    $total_sar_organisme += $value[$i]["sar"];
                }
                $dataSar[$key] = $totalSar;
            }

            $total_reversements = $services->getTotalReversements($organisme, $vraiDateDebut, $vraiDateFin);
            //dd($dataSar);

            // Alerte succès du calcul de l'ESD
            $this->addFlash("success","La dette de l'organisme ". $organisme->getSigle() ." a été évaluée avec succès !!!");

            if ($total_reversements == null)
                $total_reversements = 0;

            return $this->render('esd/esd_result.html.twig', [
                'dateDebut' => $vraiDateDebut->format('d-m-Y'),
                'dateFin' => $vraiDateFin->format('d-m-Y'),
                'id_agent' => $id_agent,
                'dataSar' => $dataSar,
                'dataCotis' => $dataCotis,
                'sar' => $sar,
                'total_sar_organisme' => $total_sar_organisme,
                'total_reversement' => $total_reversements,
                'organisme' => $organisme,
                'grade_agent' => $grade_agent,
            ]);
        }

        return $this->render('esd/esd_orga.html.twig', [
            'form' => $form->createView(),
            'organisme' => $organisme
        ]);
    }
    /** Fin esd_evaluate */

    #[Route('/esd/{id}/{debut}/{fin}/{sar}/{dr}/{rar}', name:'esd_pdf')]
    public function esdOrganismePDF(Organismes $organisme, PDFService $pdf, \DateTime $debut, \DateTime $fin,
        int $sar, int $dr, int $rar, Pdf $snappy)
    {
        $dateDebut = $debut->format('Ymd');
        $dateFin = $fin->format('Ymd');
        $sar = $sar;
        $dr = $dr;
        $rar = $rar;
        $filename = $organisme->getSigle()."-".$dateDebut."-".$dateFin.".pdf";

        //Page à télécharger en pdf
        $html = $this->renderView('esd/esd_pdf_orga.html.twig', array(
            'organisme' => $organisme,
            'sar' => $sar,
            'dejaReverser' => $dr,
            'resteAreverser' => $rar,
            'debut' => $debut->format('d-m-Y'),
            'fin' => $fin->format('d-m-Y'),
        ));

        /** Pour KnpSnappyPdf */
        return new PdfResponse($snappy->getOutputFromHtml($html), $filename, ['images' => true]);

        /** pour domPDF
        $pdf->showPdfFile($html, $filename);
        return new Response(); */

    }
    /** Fin esdOrganismePDF */

    #[Route('/esd/agent/{id}∕{dateDebut}/{dateFin}', name: 'esd_agent_details')]
    public function detailsESDAgent(Services $services, AgentDetache $agentDetache, Request $request,
        \DateTime $dateDebut, \DateTime $dateFin): Response
    {
        $gradeDet = $agentDetache->getGradeDet();
        $classeDet = $agentDetache->getClasseDet();
        $echelonDet = $agentDetache->getEchelonDet();
        $indiceDet = $services->getIndice($gradeDet, $classeDet, $echelonDet);
        $dateIntegration = $agentDetache->getDateIntegration();
        $dateDet = $agentDetache->getDateDet();
        $dateFinDet = $agentDetache->getDateFinDet();
        $totalCotis = $services->getTotalCotisations($agentDetache, $dateDebut, $dateFin);

        if($dateFin <= $dateDet)
        {
            $detailsEsdAgent["dateDebut"] = $dateDebut;
            $detailsEsdAgent["dateFin"] = $dateFin;
            $detailsEsdAgent["sb"] = 0;
            $detailsEsdAgent["partSalariale"] = 0;
            $detailsEsdAgent["partPatronale"] = 0;
            $detailsEsdAgent["sar"] = 0;
            if($gradeDet >= "60000" && $gradeDet < "62000") {
                $detailsEsdAgent["echelon"] = $echelon;
            } else {
                $detailsEsdAgent["indice"] = $indiceDet;
            }
            $sar[] = $detailsEsdAgent;
            $totalSar = 0;
        }
        else {
            //Si la date de début est inférieure à la date de détachement, la date de début sera la date de détachement
            if ($dateDet >= $dateDebut && $dateDet <= $dateFin) {
                $dateDebut = $dateDet;
            }

            //Si la date de fin est supérieure à la date de fin de détachement, la date de fin sera la date de fin de détachement
            if ($dateFinDet > date_create("0001-01-01") && $dateFinDet <= date_create(date("Y-m-d"))) {
                if ($dateFinDet < $dateFin) {
                    $dateFin = $dateFinDet;
                }
            }

            if ($gradeDet >= "60000" && $gradeDet < "62000") {
                $first_echelon = $services->getFirstEchelon($gradeDet, $echelonDet, $dateIntegration, $dateDebut, $dateDet);
                // $sar = somme à reverser pour un agent détatché
                $sar = $services->getSommeAReverserCT($dateDebut, $dateFin, $first_echelon, $gradeDet, $dateIntegration, $dateDet);
            } else {
                $first_indice = $services->getFirstIndice($gradeDet, $indiceDet, $dateIntegration, $dateDebut, $dateDet);
                // $sar = somme à reverser pour un agent détatché
                $sar = $services->getSommeAReverserFC($dateDebut, $dateFin, $first_indice, $gradeDet, $dateIntegration, $dateDet);
            }

            $totalSar = 0;

            for ($i = 0; $i < count($sar); $i++) {
                $totalSar += $sar[$i]["sar"];
            }
        }

        return $this->render('esd/esd_details.html.twig',[
            'sar' => $sar,
            'totalSar' => $totalSar,
            'totalCotis' => $totalCotis,
            'dateDebut' => $dateDebut->format('d-m-Y'),
            'dateFin' => $dateFin->format('d-m-Y'),
            'agentDetache' => $agentDetache
        ]);
    }
    /** Fin esd_agent_details */


    #[Route('/esd', name: 'esd_orga')]
    public function listOrganisme(OrganismesRepository $organismesRepository): Response
    {
        if($this->getUser()->getOrganisme()->getSigle() === "MINFI" | $this->isGranted('ROLE_ADMIN'))
            $listeOrganismes = $organismesRepository->findAll();
        else
            $listeOrganismes = $organismesRepository->findBy(['id' => $this->getUser()->getOrganisme()]);

        return $this->render('esd/orga.html.twig', [
            'listeOrganismes' => $listeOrganismes,
        ]);
    }

    #[Route('/esdmensuel', name: 'esd_orga_mensuel')]
    public function listOrganisme2(OrganismesRepository $organismesRepository): Response
    {
        if($this->getUser()->getOrganisme()->getSigle() === "MINFI" | $this->isGranted('ROLE_ADMIN'))
            $listeOrganismes = $organismesRepository->findAll();
        else
            $listeOrganismes = $organismesRepository->findBy(['id' => $this->getUser()->getOrganisme()]);

        return $this->render('esd/orga2.html.twig', [
            'listeOrganismes' => $listeOrganismes,
        ]);
    }

    #[Route('/esdmensuel/{id}', name: 'reversement_mensuel')]
    public function reversementMensuel(Services $services, Organismes $organisme, Request $request): Response
    {
        // utilisateur connecté
        $user = $this->getUser();
        // pour l'historisation de l'action
        $history = new Historique();

        if ( in_array(date("m")-1, array(1,3,5,7,8,10,12)) ) {
            $dateDebut = date_create(date("Y-m-d", mktime(0,0,0,date("m")-1,1,date("Y"))));
            $dateFin     = date_create(date("Y-m-d", mktime(0,0,0,date("m"),-1,date("Y"))));
        } elseif (date("m")-1 == 2) {
            $dateDebut = date_create(date("Y-m-d", mktime(0,0,0,date("m")-1,1,date("Y"))));
            $dateFin     = date_create(date("Y-m-d", mktime(0,0,0,date("m"),1,date("Y"))));
        }
        else {
            $dateDebut = date_create(date("Y-m-d", mktime(0,0,0,date("m")-1,1,date("Y"))));
            $dateFin     = date_create(date("Y-m-d", mktime(0,0,0,date("m"),0,date("Y"))));
        }

        //dd($dateDebut, $dateFin, date("m")-0);
        $vraiDateDebut = $dateDebut;

        //Liste des agents détachés au sein de l'organisme .
        $agents = $organisme->getAgentDetaches()->toArray();
        // Tableau qui contient les id des agents détachés au sein de l'organisme
        $id_agent = [];
        // tableau: matricule => somme à reverser
        $sar_organisme = [];

        for ($i = 0; $i < count($agents); $i++){
            $dateIntegration = $agents[$i]->getDateIntegration();
            $dateDet = $agents[$i]->getDateDet();
            $gradeDet = $agents[$i]->getGradeDet();
            $classeDet = $agents[$i]->getClasseDet();
            $echelonDet = $agents[$i]->getEchelonDet();
            $indiceDet = $services->getIndice($gradeDet, $classeDet, $echelonDet);

            //Si la date de début est inférieure à la date de détachement, la date de début sera la date de détachement
            if ($dateDet >= $dateDebut){
                $dateDebut = $dateDet;
            }

            //Somme à reverser selon que l'agent détaché soit fonctionnnaire ou du code du travail
            if($gradeDet >= "60000" && $gradeDet < "62000") {
                $first_echelon = $services->getFirstEchelon($gradeDet, $echelonDet, $dateIntegration, $dateDebut, $dateDet);
                // $sar = somme à reverser pour un agent détatché du code du travail
                $sar = $services->getSommeAReverserCT($dateDebut, $dateFin, $first_echelon, $gradeDet, $dateIntegration, $dateDet);
                $sar_organisme[$agents[$i]->getNoms() . " (" . $agents[$i]->getMatricule() . ")"] = $sar;
                // on stocke l'ID de l'agent détaché qui va nous aider pour afficher les détails de l'évaluation de son ESD
                $id_agent[] = $agents[$i]->getId();
                $grade_agent[] = $agents[$i]->getGradeDet();
            } else {
                $first_indice = $services->getFirstIndice($gradeDet, $indiceDet, $dateIntegration, $dateDebut, $dateDet);
                // $sar = somme à reverser pour un agent détatché fonction
                $sar = $services->getSommeAReverserFC($dateDebut, $dateFin, $first_indice, $gradeDet, $dateIntegration, $dateDet);
                $sar_organisme[$agents[$i]->getNoms() . " (" . $agents[$i]->getMatricule() . ")"] = $sar;
                // on stocke l'ID de l'agent détaché qui va nous aider pour afficher les détails de l'évaluation de son ESD
                $id_agent[] = $agents[$i]->getId();
                $grade_agent[] = $agents[$i]->getGradeDet();
            }
        }

        $total_sar_organisme = 0;
        $dataSar = [];

        foreach ($sar_organisme as $key => $value){
            $totalSar = 0;
            for($i = 0; $i < count($value); $i++) {
                $totalSar += $value[$i]["sar"];
                $total_sar_organisme += $value[$i]["sar"];
            }
            $dataSar[$key] = $totalSar;
        }

        // Alerte succès de l'enregistrement d'un nouveau détachement
        $this->addFlash("success","La somme à reverser mensuellement par l'organisme ". $organisme->getSigle() ." a été évaluée avec succès !!!");

        return $this->render('esd/esd_mensuel.html.twig', [
            'dateDebut' => $vraiDateDebut->format('d-m-Y'),
            'dateFin' => $dateFin->format('d-m-Y'),
            'id_agent' => $id_agent,
            'dataSar' => $dataSar,
            'sar' => $sar,
            'total_sar_organisme' => $total_sar_organisme,
            'organisme' => $organisme,
            'grade_agent' => $grade_agent,
        ]);
    }
    /** Fin reversement_mensuel */
}
