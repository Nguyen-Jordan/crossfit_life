<?php

namespace App\Controller;

use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profil', name: 'profile_')]
class ProfileController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'Profile de l\'utilisateur',
        ]);
    }

    #[Route('/modifier/pass', name: 'edit_pass')]
    public function EditPassword(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine): Response
    {
      if ($request->isMethod('POST')) {
        $em = $this->$doctrine->getManager();

        $user = $this->getUser();

        // Je vérifie si les 2 mots de passe sont identiques
        if($request->request->get('pass') == $request->request->get('pass2')){
          $user->setPassword($passwordHasher->hashPassword($user, $request->request->get('pass')));
          $em->flush();
          $this->addFlash('message', 'Mot de passe mis à jour avec succès');

          return $this->redirectToRoute('profile_index');
        }
        $this->addFlash('danger', 'Les deux mots de passe ne sont pas identiques');
      }

      return $this->render('profile/editpass.html.twig');
    }
}
