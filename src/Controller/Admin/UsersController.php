<?php

namespace App\Controller\Admin;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class UsersController extends AbstractController
{
  #[Route('/', name: 'index')]
public function index(): Response
  {
    return $this->render('admin/users/index.html.twig');
  }
  
  #[Route('/utilisateurs', name: 'utilisateurs')]
  public function usersList(UsersRepository $users)
  {
    return $this->render("admin/users/users.html.twig", [
      'users' => $users->findAll()
    ]);
  }
}