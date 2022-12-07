<?php

namespace App\Controller;

use App\Form\ResetPasswordRequestType;
use App\Form\ResetPasswordType;
use App\Repository\UsersRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('/security/login.html.twig', [
          'last_username' => $lastUsername,
          'error' => $error
        ]);
    }

    #[Route(path: '/deconnexion', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/changement-pass', name: 'change_password')]
    public function changePassword(
      Request $request,
      UsersRepository $usersRepository,
      TokenGeneratorInterface $generator,
      EntityManagerInterface $em,
      SendMailService $mail
    ):Response
    {
        $form = $this->createForm(ResetPasswordRequestType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          // Je vais cherger l'utilisateur par son email
          $user = $usersRepository->findOneByEmail($form->get('email')->getData());

          // Je vérifie si j'ai un utilisateur
          if ($user){
            // Je génère un token de réinitialisation
            $token = $generator->generateToken();
            $user->setResetToken($token);
            $em->persist($user);
            $em->flush();

            // Je génère un lien de réinitialisation du mot de passe
            $url = $this->generateUrl('reset_password', ['token' => $token],
              UrlGeneratorInterface::ABSOLUTE_URL);

            // Je crée les données du mail
            $context = ['url' => $url, 'user' => $user];

            // J'envoie le mail
            $mail->send(
              'no-reply@crossfitlife.com',
              $user->getEmail(),
              'Réinitialisation du mot de passe',
              'password_reset',
              $context
            );

            $this->addFlash('success', 'Email envoyé avec succès');
            return $this->redirectToRoute('app_login');
          }
          $this->addFlash('danger', 'Un problème est survenue');
          return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_password_request.html.twig', [
          'requestPassForm' => $form->createView()
        ]);
    }

    #[Route('/changement-pass/{token}', name: 'reset_password')]
    public function resetPass(
      string $token,
      Request $request,
      UsersRepository $usersRepository,
      EntityManagerInterface $em,
      UserPasswordHasherInterface $passwordHasher
    ): Response
    {
      // Je vérifie s'il y a ce token dans la base de données
      $user = $usersRepository->findOneByResetToken($token);

      if ($user) {
        $form = $this->createForm(ResetPasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
          // J'efface le token
          $user->setResetToken('');
          $user->setPassword(
            $passwordHasher->hashPassword(
              $user,
              $form->get('password')->getData()
            )
          );
          $em->persist($user);
          $em->flush();

          $this->addFlash('success', 'Mot de passe Changé avec succès');
          return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_password.html.twig', [
          'passForm' => $form->createView()
        ]);
      }
      $this->addFlash('danger', 'Jeton invalide');
      return $this->redirectToRoute('app_login');

    }
}
