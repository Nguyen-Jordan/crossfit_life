<?php

namespace App\Controller;

use App\Entity\Franchises;
use App\Repository\FranchisesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/franchises', name: 'franchises_')]
class FranchisesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(FranchisesRepository $franchisesRepository): Response
    {
        return $this->render('partner/franchises/index.html.twig', [
            'franchises' => $franchisesRepository->findBy([],
              ['id' => 'asc'])
        ]);
    }
  
  
    #[Route('/{slug}', name: 'details')]
    public function details(FranchisesRepository $franchises, Franchises $franchise): Response
    {
      //On va chercher la liste des structures de la franchise et les droits
      $result = $franchises->findRights([$franchise],['id' => 'asc']);
  
      return $this->render('partner/franchises/details.html.twig', [
        'franchise' => $franchise,
        'result' => $result
      ]);
    }
}
