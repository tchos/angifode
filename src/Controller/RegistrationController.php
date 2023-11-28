<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Require ROLE_ADMIN for all the actions of this controller
 */
#[IsGranted('ROLE_ADMIN')]
class RegistrationController extends AbstractController
{
    #[Route('/{_locale<%app.supported_locales%>}/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator,
                             UserAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        // Historisation de la création d'un user
        $history = new Historique();

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setCreatedBy($this->getUser()->getFullName())
                ->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $history->setTypeAction("CREATE")
                ->setAuteur($this->getUser()->getUsername())
                ->setNature("COMPTE_USER")
                ->setClef($form->get('username')->getData())
                ->setDateAction(new \DateTime())
            ;

            $entityManager->persist($user);
            $entityManager->persist($history);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/{_locale<%app.supported_locales%>}/user/{id}/edit', name: 'user_edit')]
    public function edit(EntityManagerInterface $manager, Request $request, User $user,
                            TranslatorInterface $translator): Response
    {
        // pour l'historisation de l'action
        $history = new Historique();

        // constructeur de formulaire de saisie des actes de décès
        $form = $this->createForm(RegistrationFormType::class, $user);

        // handlerequest() permet de parcourir la requête et d'extraire les informations du formulaire
        $form->handleRequest($request);

        /**
         * Ayant extrait les infos saisies dans le formulaire,
         * on vérifie que le formulaire a été soumis et qu'il est valide
         */
        if($form->isSubmitted() && $form->isValid())
        {
            $history->setTypeAction("UPDATE")
                ->setAuteur($this->getUser()->getUsername())
                ->setNature("COMPTE_USER")
                ->setClef($form->get('username')->getData())
                ->setDateAction(new \DateTime())
            ;
            // Persistence de l'entité Organismes
            $manager->persist($user);
            $manager->persist($history);
            $manager->flush();

            // Alerte succès de la mise à jour des informations sur un organisme
            $this->addFlash("warning", $translator->trans("Utilisateur modifié avec succès !"));

            return $this->redirectToRoute('user_list');
        }

        return $this->render('registration/user_edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    #[Route('/{_locale<%app.supported_locales%>}/user/{id}/resetpassword', name: 'user_resetpassword')]
    public function resetPassword(EntityManagerInterface $entityManager, Request $request, User $user,
                                    UserPasswordHasherInterface $userPasswordHasher, TranslatorInterface $translator): Response
    {
        // pour l'historisation de l'action
        $history = new Historique();

        $plainPassword = 'gomez';
        $hashedPassword = $userPasswordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        $history->setTypeAction("RESET")
            ->setAuteur($this->getUser()->getUsername())
            ->setNature("PASSWORD")
            ->setClef($user->getUsername())
            ->setDateAction(new \DateTime())
        ;

        $entityManager->persist($user);
        $entityManager->persist($history);
        $entityManager->flush();

        // Alerte succès de la mise à jour des informations sur un organisme
        $this->addFlash("warning", $translator->trans("Le mot de passe a été réinitialisé avec succès !"));

        return $this->redirectToRoute('user_list');

    }

    /**
     * Liste des utilisateurs de l'application ANGIFODE
     * @param EntityManagerInterface $manager
     * @param UserRepository $repos
     * @return Response
     */
    #[Route('/{_locale<%app.supported_locales%>}/user/list', name: 'user_list')]
    public function lister_user(EntityManagerInterface $manager,UserRepository $repos):Response
    {
        $listeUsers = $repos->findAll();
        return $this->render('registration/user_list.html.twig',[
            'listeUsers' => $listeUsers,
        ]);
    }
}
