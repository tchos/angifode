<?php

namespace App\Controller;

use App\Form\UpdatePasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserController extends AbstractController
{
    #[Route(path: '/{_locale<%app.supported_locales%>}/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, EntityManagerInterface $manager,
        UserRepository $repos): Response
    {
        if ($this->getUser()) {
            $utilisateur = $this->getUser()->setLastVisitDate(new \DateTime());

            // On enregistre la dernière date de connexion dans la bd
            $manager->persist($utilisateur);
            $manager->flush();

            // redirection vers la page "app_home"
            return $this->redirectToRoute('app_home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/{_locale<%app.supported_locales%>}/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/{_locale<%app.supported_locales%>}/updatepassword', name: 'password_edit')]
    #[IsGranted('ROLE_USER')]
    public function updatePassword (UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager, TranslatorInterface $translator,
                          UserRepository $repos, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UpdatePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $old_password = $form->get('old_password')->getData();
            // Si l'ancien mot de passe est le bon
            if($userPasswordHasher->isPasswordValid($user, $old_password)){
                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
                $manager->persist($user);
                $manager->flush();

                // Notification du mot de passe modifié
                $this->addFlash("success", $translator->trans("Mot de passe modifié avec succès !!!"));

                // Redirection vers la page de connexion
                return $this->redirectToRoute('app_logout');
            }else{
                // Notification du mot de passe modifié
                $this->addFlash("danger", $translator->trans("Votre ancien mot de passe n'est pas valide !!!"));
            }
        }

        return $this->render('security/password_edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
