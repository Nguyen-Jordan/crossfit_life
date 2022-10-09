<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Security\EmailVerifier;
use App\Security\UserAuthentificatorAuthenticator;
use App\Service\JWTService;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher,
     UserAuthenticatorInterface $userAuthenticator, UserAuthentificatorAuthenticator $authenticator,
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


            // On génère le JWT de l'utilisateur
            // On crée le Header
            $header = [
              'typ' => 'JWT',
              'alg' => 'HS256'
            ];

            // On crée le Payload
            $payload = [
              'user_id' => $user->getId()
            ];

            // On crée le Payload
            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

            // On envoie un mail de confirmation
            $mail->send(
              'no-reply@crossfit.net',
              $user->getEmail(),
              'Activation de votre compte',
              'register',
              compact('user', 'token')
            );

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('admin/registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/Verif/{token}', name: 'verify_user')]
    public function verifyUser($token, JWTService $jwt, UsersRepository $usersRepository, EntityManagerInterface $em): Response {
      // On vérifie si le token est valide, n'a pas expiré et n'a pas été modifié
      if ($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter('app.jwtsecret'))){
        // On récupère le payload
        $payload = $jwt->getPayload($token);

        // On récupère le user du token
        $user = $usersRepository->find($payload['user_id']);

        // On vérifie que l'utilisateur existe et n'a pas encore activé son compte
        if ($user && !$user->getIsVerified()){
          $user->setIsVerified(true);
          $em->flush($user);
          $this->addFlash('success', 'Utilisateur activé');
          return $this->redirectToRoute('main');
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

      // On génère le JWT de l'utilisateur
      // On crée le Header
      $header = [
        'typ' => 'JWT',
        'alg' => 'HS256'
      ];

      // On crée le Payload
      $payload = [
        'user_id' => $user->getId()
      ];

      // On crée le Payload
      $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

      // On envoie un mail de confirmation
      $mail->send(
        'no-reply@crossfit.net',
        $user->getEmail(),
        'Activation de votre compte',
        'register',
        compact('user', 'token')
      );

      $this->addFlash('success', 'Email de vérification envoyé');
      return $this->redirectToRoute('main');
    }
}
