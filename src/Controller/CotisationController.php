<?php

namespace App\Controller;

use App\Entity\Cotisation;
use App\Entity\Historique;
use App\Entity\Reversement;
use App\Form\CotisationEditType;
use App\Form\CotisationType;
use App\Repository\AgentDetacheRepository;
use App\Repository\CotisationRepository;
use App\Repository\OrganismesRepository;
use App\Services\Services;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Require ROLE_USER for all the actions of this controller
 */
#[IsGranted('ROLE_USER')]
class CotisationController extends AbstractController
{
    #[Route('/{_locale<%app.supported_locales%>}/cotisation/reversement/{reversement}', name: 'cotisation_new')]
    public function index(EntityManagerInterface $manager, Request $request, Reversement $reversement, TranslatorInterface $translator,
                          CotisationRepository   $repos, Services $services, AgentDetacheRepository $agRepos): Response
    {
        // Pour historiser l'ajout d'une nouvelle cotisation en bd
        $historique = new Historique();
        // Nouvelle cotisation
        $cotisation = new Cotisation();
        // User connecté
        $user = $this->getUser();
        // Organisme pour lequel on enregistre la cotisation
        $organisme = $reversement->getOrganisme();

        //Liste des agants pour lesquels on n'a pas encore cotisé
        $anc = $services->getListeACotiser($reversement,$organisme);

        //dd($anc);
        // Formulaire de cotisation
        $form = $this->createForm(CotisationType::class, $cotisation,['anc' => $anc]);

        // Recupération des informations saisies dans le formulaire de cotisation
        $form->handleRequest($request);

        //dd($request->request->get('cotisation')['agentdetache']);

        /**
         * Ayant extrait les infos saisies dans le formulaire,
         * on vérifie que le formulaire a été soumis et qu'il est valide
         */
        if($form->isSubmitted() && $form->isValid())
        {
            $idAgentDetache = $request->request->get('cotisation')['agentdetache'];
            $agent = $agRepos->find($idAgentDetache);
            $totalCotisation = $repos->sommeCotisation($reversement);
            $montantReversement = intval($reversement->getMontantRev());
            //dd($form->getData('cotTotale')->getCotTotale() + $totalCotisation);
            //dd($totalCotisation);

            // Il faut add 1 au montantReversement pour contourner le bug de l'égalité entre le int et le float.
            if($montantReversement + 1 > ($form->getData('cotTotale')->getCotTotale() + $totalCotisation)) {
                $cotisation ->setDateDebutCot($reversement->getDateDebRev())
                    ->setDateFinCot($reversement->getDateFinRev())
                    ->setReversement($reversement)
                    ->setAgent($agent)
                ;
                //dd($cotisation);
                // Table historique pour les cotisations
                $historique ->setTypeAction("CREATE")
                    ->setAuteur($user->getUsername())
                    ->setNature("COTISATION")
                    ->setClef($agent->getMatricule())
                    ->setDateAction(new \DateTimeImmutable());

                // Persistence de l'entité Organismes et Historique
                $manager->persist($cotisation);
                $manager->persist($historique);
                $manager->flush();

                // Alerte succès de l'enregistrement d'un reversement
                $this->addFlash("success",
                                $translator->trans("La cotisation a été enregistrée avec succès !!!"));

                return $this->redirectToRoute('cotisation_new', [
                    'reversement' => $reversement->getId(),
                ]);
            } else {
                $ecart = ($form->getData('cotTotale')->getCotTotale() + $totalCotisation) - $montantReversement;
                // $form->get('cotTotale') me donne accès au champ cotTotale du formulaire
                $messages = $translator->trans("La somme des cotisations dépasse de " . $ecart . " FCFA le montant du reversement !");
                $form->get('cotTotale')->addError(
                    new FormError($translator->trans("La somme des cotisations dépasse de " . $ecart . " FCFA le montant du reversement !"))
                );
            }
        }

        $listeCotisation = $repos->findListCotisation($reversement->getId());
        $totalCotisation = $repos->sommeCotisation($reversement);

        return $this->render('cotisation/cotisation_add.html.twig', [
            'form' => $form->createView(),
            'reversement' => $reversement,
            'listeCotisation' => $listeCotisation,
            'totalCotisation' => $totalCotisation
        ]);
    }

    #[Route('/{_locale<%app.supported_locales%>}/cotisation/{id}/edit', name: 'cotisation_edit')]
    public function edit_cotisation(EntityManagerInterface $manager, Request $request, Cotisation $cotisation, TranslatorInterface $translator,
                                    CotisationRepository   $repos, Services $statistiques, AgentDetacheRepository $agRepos): Response
    {
        // Pour historiser l'ajout d'une nouvelle cotisation en bd
        $historique = new Historique();

        // User connecté
        $user = $this->getUser();

        // Reversement concerné par la cotisation
        $reversement = $cotisation->getReversement();

        // Agent pour lequel l'on veut modifier le montant de la cotisation
        $agent = $cotisation->getAgent();

        // Formulaire de cotisation
        $form = $this->createForm(CotisationEditType::class, $cotisation);

        // Recupération des informations saisies dans le formulaire de cotisation
        $form->handleRequest($request);

        /**
         * Ayant extrait les infos saisies dans le formulaire,
         * on vérifie que le formulaire a été soumis et qu'il est valide
         */
        if($form->isSubmitted() && $form->isValid())
        {
            $totalCotisation = ($repos->sommeCotisation($reversement) - $cotisation->getCotTotale());
            $montantReversement = (intval($reversement->getMontantRev()) + $cotisation->getCotTotale());

            if($montantReversement > ($form->getData('cotTotale')->getCotTotale() + $totalCotisation)) {
                // Table historique pour les cotisations
                $historique ->setTypeAction("UPDATE")
                    ->setAuteur($user->getUsername())
                    ->setNature("COTISATION")
                    ->setClef($agent->getMatricule())
                    ->setDateAction(new \DateTimeImmutable());

                // Persistence de l'entité Organismes et Historique
                $manager->persist($cotisation);
                $manager->persist($historique);
                $manager->flush();

                // Alerte succès de l'enregistrement d'un reversement
                $this->addFlash("success","Le montant de la cotisation de l'agent " .
                    $agent->getNoms() . "(" . $agent->getMatricule() . ")" . " du reversement " . $reversement .
                    ", a été modifié avec succès !!!");

                return $this->redirectToRoute('cotisation_new', [
                    'reversement' => $reversement->getId(),
                ]);
            } else {
                $ecart = ($form->getData('cotTotale')->getCotTotale() + $totalCotisation) - $montantReversement;
                // $form->get('cotTotale') me donne accès au champ cotTotale du formulaire
                $form->get('cotTotale')->addError(
                    new FormError($translator->trans("La somme des cotisations dépasse de " . $ecart . " FCFA le montant du reversement !"))
                );
            }
        }

        //$listeCotisation = $repos->findListCotisation($reversement->getId());
        $totalCotisation = $repos->sommeCotisation($reversement) - $cotisation->getCotTotale();

        return $this->render('cotisation/cotisation_edit.html.twig', [
            'form' => $form->createView(),
            'cotisation' => $cotisation,
            'reversement' => $reversement,
            'totalCotisation' => $totalCotisation,
            'agent' => $agent->getNoms() . "(" . $agent->getMatricule() . ")",
        ]);
    }

    /**
     * Permet de supprimer une cotisation
     *
     * @param EntityManagerInterface $manager
     * @param Cotisation $cotisation
     * @return void
     */
    #[Route("/{_locale<%app.supported_locales%>}/cotisation/{id}/delete", name:"cotisation_delete")]
    public function delete_cotisation(EntityManagerInterface $manager, Cotisation $cotisation, TranslatorInterface $translator)
    {
        // Reversement concernant la cotisation à supprimer
        $reversement = $cotisation->getReversement();

        // Agent pour lequel l'on veut supprimer la cotisation
        $agent = $cotisation->getAgent();

        $manager->remove($cotisation);
        $manager->flush();

        //Message flash de la suppression de la cotisation
        $this->addFlash(
            "success",
            $translator->trans("La cotisation de l'agent <strong>{$agent->getNoms()}({$agent->getMatricule()}) 
                </strong> du reversement {$reversement} a bien été supprimé"));
        /**
        if($this->getUser() == $acteDeces->getAgentSaisie())
        {
            $manager->remove($acteDeces);
            $manager->flush();
            $this->addFlash(
                "success",
                "L'acte de décès n° <strong>{$acteDeces->getNumeroActe()}</strong> a bien été supprimé"
            );
        } else {
            $this->addFlash(
                "warning",
                "Vous ne pouvez pas supprimer l'acte de décès n° <strong>{$acteDeces->getNumeroActe()}</strong> 
                car vous n'en êtes pas l'auteur !"
            );
        }
         * */
        return $this->redirectToRoute('cotisation_new', [
            'reversement' => $reversement->getId(),
        ]);
    }
}
