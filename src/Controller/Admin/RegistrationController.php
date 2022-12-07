<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Service\JWTService;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/admin/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher,
     EntityManagerInterface $entityManager, SendMailService $mail, JWTService $jwt): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encoder le mot de passe en clair
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // Je génère le JWT de l'utilisateur
            // Je crée le Header
            $header = [
              'typ' => 'JWT',
              'alg' => 'HS256'
            ];

            // Je crée le Payload
            $payload = [
              'user_id' => $user->getId()
            ];

            // Je crée le Payload
            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

            // J'envoie un mail de confirmation
            $mail->send(
              'no-reply@crossfitlife.com',
              $user->getEmail(),
              'Activation de votre compte',
              'register',
              compact('user', 'token')
            );

            $this->addFlash('success', 'Utilisateur inscrit avec succès');
            return $this->redirectToRoute('admin_utilisateurs');
        }
        return $this->render('admin/registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/Verif/{token}', name: 'verify_user')]
    public function verifyUser($token, JWTService $jwt, UsersRepository $usersRepository, EntityManagerInterface $em): Response {
      // Je vérifie si le token est valide, n'a pas expiré et n'a pas été modifié
      if ($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter('app.jwtsecret'))){
        // Je récupère le payload
        $payload = $jwt->getPayload($token);

        // Je récupère le token de l'utilisateur
        $user = $usersRepository->find($payload['user_id']);

        // Je vérifie que l'utilisateur existe et n'a pas encore activé son compte
        if ($user && !$user->getIsVerified()){
          $user->setIsVerified(true);
          $em->flush($user);
          $this->addFlash('success', 'Utilisateur activé');
          return $this->redirectToRoute('change_password');
        }
      }
      // Ici un problème se pose dans le token
      $this->addFlash('danger', 'Le token est invalide ou expiré');
      return $this->redirectToRoute('main');
    }

    #[Route('/renvoiVerif', name: 'resend_verif')]
    public function resendVerif(JWTService $jwt, SendMailService $mail, UsersRepository $usersRepository): Response {
      $user = $this->getUser();

      if (!$user){
        $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page');
        return $this->redirectToRoute('app_login');
      }

      if ($user->getIsVerified()){
        $this->addFlash('warning', 'Cet utilisateur est déjà activé');
        return $this->redirectToRoute('main');
      }

      // Je génère le JWT de l'utilisateur
      // Je crée le Header
      $header = [
        'typ' => 'JWT',
        'alg' => 'HS256'
      ];

      // Je crée le Payload
      $payload = [
        'user_id' => $user->getId()
      ];

      // On crée le Payload
      $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

      // J'envoie un mail de confirmation
      $mail->send(
        'no-reply@crossfit.net',
        $user->getEmail(),
        'Activation de votre compte',
        'register',
        compact('user', 'token')
      );

      $this->addFlash('success', 'Email de vérification envoyé');
      return $this->redirectToRoute('change_password');
    }

}
