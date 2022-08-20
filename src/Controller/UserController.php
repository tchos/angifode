<?php

namespace App\Controller;

use App\Form\UpdatePasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, EntityManagerInterface $manager,
        UserRepository $repos): Response
    {
        if ($this->getUser()) {
            $utilisateur = $this->getUser()->setLastVisitDate(new \DateTime());

            // On enregistre la dernière date de connexion dans la bd
            $manager->persist($utilisateur);
            $manager->flush();

            // redirection vers la page "agent_new"
            return $this->redirectToRoute('agent_new');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/updatepassword', name: 'password_edit')]
    public function updatePassword (UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager,
                          UserRepository $repos, Request $request): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UpdatePasswordType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $old_password = $form->get('old_password')->getData();
            // Si l'ancien mot de passe est le bon
            if($encoder->isPasswordValid($user, $old_password)){
                $user->setPassword(
                    $encoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
                $manager->persist($user);
                $manager->flush();

                // Notification du mot de passe modifié
                $this->addFlash("success", "Mot de passe modifié avec succès !!!");

                // Redirection vers la page de connexion
                return $this->redirectToRoute('app_logout');
            }else{
                // Notification du mot de passe modifié
                $this->addFlash("danger", "Votre ancien mot de passe n'est pas valide !!!");
            }
        }

        return $this->render('security/password_edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
