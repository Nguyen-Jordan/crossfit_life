<?php

namespace App\Controller\Admin;

use App\Entity\Franchises;
use App\Entity\Users;
use App\Form\EditUserType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

#[Route('/admin/utilisateurs', name: 'admin_')]
class UsersController extends AbstractController
{
  #[Route('/', name: 'utilisateurs')]
  public function usersList(UsersRepository $users)
  {

    return $this->render("admin/users/users.html.twig", [
      'users' => $users->findAll()
    ]);
  }
  
  #[Route('/modifier/{lastname}', name: 'modifier_utilisateur')]
  public function editUser(
    Users $user,
    Request $request,
    ManagerRegistry $doctrine
  )
  {
    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    $form = $this->createForm(EditUserType::class, $user);
    $form->handleRequest($request);
    
    if($form->isSubmitted() && $form->isValid()){
      $entityManager = $doctrine->getManager();
      $entityManager->persist($user);
      $entityManager->flush();
      
      $this->addFlash('success', 'Utilisateur modifié avec succès');
      return $this->redirectToRoute('admin_utilisateurs');
    }
    return $this->render('admin/users/edituser.html.twig', [
      'userForm' => $form->createView()
    ]);
  }

  #[Route('/supprimer/{id}', name: 'delete')]
  public function delete(
    Request $request,
    Users $user,
    EntityManagerInterface $em
  ): Response
  {
    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    $submittedToken = $request->request->get('token');

    if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {

      $em->remove($user);
      $em->flush();

      $this->addFlash('success', 'Utilisateur supprimée avec succès');
    }

    return $this->redirectToRoute('admin_utilisateurs');
  }
}