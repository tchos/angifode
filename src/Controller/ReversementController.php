<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Entity\Reversement;
use App\Form\ReversementType;
use App\Repository\AgentDetacheRepository;
use App\Repository\ReversementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ReversementController extends AbstractController
{
    #[Route('/reversement', name: 'reversement_new')]
    #[IsGranted("ROLE_USER")]
    public function create_reversement(EntityManagerInterface $manager, Request $request, SluggerInterface $slugger): Response
    {
        // utilisateur connecté
        $user = $this->getUser();
        // pour l'historisation de l'action
        $historique = new Historique();
        // Variable que nous allons utiliser pour enregistrer un nouveau reversement
        $reversement = new Reversement();

        // constructeur de formulaire de creation d'un organisme
        $form = $this->createForm(ReversementType::class, $reversement);

        // handlerequest() permet de parcourir la requête et d'extraire les informations du formulaire
        $form->handleRequest($request);

        /**
         * Ayant extrait les infos saisies dans le formulaire,
         * on vérifie que le formulaire a été soumis et qu'il est valide
         */
        if($form->isSubmitted() && $form->isValid())
        {
            // On récupère le sigle et la date de reversement qui vont constituer le nom du fichier stocké en bd
            $datereversement = date_format($form->get('dateTitre')->getData(), 'Ymd');
            $anneeversement = date_format($form->get('dateTitre')->getData(), 'Y');
            $sigle = $form->get('organisme')->getData()->getSigle();

            /** @var UploadedFile $preuveRev */
            $preuveRev = $form->get('preuveRev')->getData();

            // this condition is needed because the 'preuveRev' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($preuveRev) {
                $newFilename = $sigle . '-' . $datereversement . '-' . uniqid() . '.' . $preuveRev->guessExtension();

                // 'preuve_reversement_directory' = Chemin par défaut configuré dans le fichier service.yaml
                $chemin = $this->getParameter('preuve_reversement_directory')."/".$sigle."/".$anneeversement;

                // Move the file to the directory where file are stored
                try {
                    if(is_dir($chemin)){
                        $preuveRev->move($chemin,$newFilename);
                    }else {
                        mkdir($chemin,0777, true);
                        $preuveRev->move($chemin,$newFilename);
                    }

                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $reversement->setPreuveRev($newFilename)
                            ->setUserRev($user);

                $historique->setTypeAction("CREATE")
                        ->setAuteur($user->getUsername())
                        ->setNature("REVERSEMENT")
                        ->setClef($form->get('refTitre')->getData())
                        ->setDateAction(new \DateTimeImmutable());

                //$agentsDetaches = $reversement->getOrganisme()->getAgentDetaches()->getValues();
                //dd($agentsDetaches);

                // Persistence de l'entité Organismes et Historique
                $manager->persist($reversement);
                $manager->persist($historique);
                $manager->flush();

                // Alerte succès de l'enregistrement d'un reversement
                $this->addFlash("success","Le reversement a été enregistré avec succès !!!");

                return $this->redirectToRoute('cotisation_new', [
                    'reversement' => $reversement->getId(),
                ]);
            }
        }

        return $this->render('reversement/reversement_add.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/reversement/list', name: 'reversement_list')]
    #[IsGrante("ROLE_USER")]
    public function lister_reversement(EntityManagerInterface $manager, Request $request,
                                       ReversementRepository $repos):Response
    {
        $listeReversements = $repos->findAll();
        $chemin = $this->getParameter('preuve_reversement_directory');
        return $this->render('reversement/reversement_list.html.twig',[
            'listeReversements' => $listeReversements,
            'chemin' => $chemin
        ]);
    }

    #[Route('/reversement/{id}/edit', name: 'reversement_edit')]
    #[IsGranted("ROLE_USER")]
    public function update_reversement(EntityManagerInterface $manager, Request $request,
                                       Reversement $reversement, SluggerInterface $slugger): Response
    {
        // utilisateur connecté
        $user = $this->getUser();
        // pour l'historisation de l'action
        $history = new Historique();

        // constructeur de formulaire de creation d'un organisme
        $form = $this->createForm(ReversementType::class, $reversement);

        // handlerequest() permet de parcourir la requête et d'extraire les informations du formulaire
        $form->handleRequest($request);

        /**
         * Ayant extrait les infos saisies dans le formulaire,
         * on vérifie que le formulaire a été soumis et qu'il est valide
         */
        if($form->isSubmitted() && $form->isValid())
        {
            // On récupère le sigle et la date de reversement qui vont constituer le nom du fichier stocké en bd
            $datereversement = date_format($form->get('dateTitre')->getData(), 'Ymd');
            $anneeversement = date_format($form->get('dateTitre')->getData(), 'Y');
            $sigle = $form->get('organisme')->getData()->getSigle();

            /** @var UploadedFile $preuveRev */
            $preuveRev = $form->get('preuveRev')->getData();

            // this condition is needed because the 'preuveRev' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($preuveRev) {
                $originalFilename = pathinfo($preuveRev->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $sigle . '-' . $datereversement . '-' . uniqid() . '.' . $preuveRev->guessExtension();

                // 'preuve_reversement_directory' = Chemin par défaut configuré dans le fichier service.yaml
                $chemin = $this->getParameter('preuve_reversement_directory')."/".$sigle."/".$anneeversement;

                // Move the file to the directory where file are stored
                try {
                    if(is_dir($chemin)){
                        $preuveRev->move($chemin,$newFilename);
                    }else {
                        mkdir($chemin,0777, true);
                        $preuveRev->move($chemin,$newFilename);
                    }

                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $reversement->setPreuveRev($newFilename)
                            ->setUserRev($user);

                $history->setTypeAction("UPDATE")
                        ->setAuteur($user->getUsername())
                        ->setNature("REVERSEMENT")
                        ->setClef($form->get('refTitre')->getData())
                        ->setDateAction(new \DateTimeImmutable());

                // Persistence de l'entité Organismes et Historique
                $manager->persist($reversement);
                $manager->persist($history);
                $manager->flush();

                // Alerte succès de l'enregistrement d'un reversement
                $this->addFlash("warning",
                    "Les modifications apportées au reversement ont été enregistrées avec succès !!!");

                return $this->redirectToRoute('reversement_list');
            }
        }

        return $this->render('reversement/reversement_edit.html.twig',[
            'form' => $form->createView(),
            'reversement' => $reversement
        ]);
    }
}
