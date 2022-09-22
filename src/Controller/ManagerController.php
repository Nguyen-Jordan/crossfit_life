<?php

namespace App\Controller;

use App\Repository\FranchisesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/manager', name: 'manager_')]
class ManagerController extends AbstractController
{
  #[Route('/', name: 'index')]
  public function index(FranchisesRepository $franchisesRepository): Response
  {
    return $this->render('profile/index.html.twig', [
      'franchises' => $franchisesRepository->findBy([],
        ['id' => 'asc'])
    ]);
  }
}