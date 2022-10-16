<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Form\EditUserType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/admin', name: 'admin_')]
class UsersController extends AbstractController
{
  #[Route('/utilisateurs', name: 'utilisateurs')]
  public function usersList(UsersRepository $users)
  {

    return $this->render("admin/users/users.html.twig", [
      'users' => $users->findAll()
    ]);
  }
  
  #[Route('/utilisateurs/modifier/{id}', name: 'modifier_utilisateur')]
  public function editUser(Users $user, Request $request, ManagerRegistry $doctrine)
  {
    $form = $this->createForm(EditUserType::class, $user);
    $form->handleRequest($request);
    
    if($form->isSubmitted() && $form->isValid()){
      $entityManager = $doctrine->getManager();
      $entityManager->persist($user);
      $entityManager->flush();
      
      $this->addFlash('message', 'Utilisateur modifié avec succès');
      return $this->redirectToRoute('admin_utilisateurs');
    }
    return $this->render('admin/users/edituser.html.twig', [
      'userForm' => $form->createView()
    ]);
  }
}