<?php

namespace App\Controller;

use App\Entity\Franchises;
use App\Entity\Structures;
use App\Repository\FranchisesRepository;
use App\Repository\StructuresDroitsRepository;
use App\Repository\StructuresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/franchises', name: 'franchises_')]
class FranchisesController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(FranchisesRepository $franchisesRepository): Response
    {
        return $this->render('admin/franchises/index.html.twig', [
            'franchises' => $franchisesRepository->findBy([],
              ['id' => 'asc'])
        ]);
    }
  
  
    #[Route('/{slug}', name: 'details')]
    public function details(StructuresDroitsRepository $repository, Franchises $franchises): Response
    {
      //On va chercher la liste des structures de la franchise et les droits
      
  
      return $this->render('admin/franchises/details.html.twig', [
        'result' => $repository->findAll(),
        'franchise' => $franchises
      ]);
    }
}
