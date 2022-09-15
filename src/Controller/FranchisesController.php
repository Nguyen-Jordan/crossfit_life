<?php

namespace App\Controller;

use App\Entity\Franchises;
use App\Entity\Structures;
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
        return $this->render('franchises/index.html.twig', [
            'franchises' => $franchisesRepository->findBy([],
              ['id' => 'asc'])
        ]);
    }
  
    #[Route('/{slug}', name: 'details')]
    public function details(Franchises $franchise, Structures $structure): Response
    {
      //On va chercher la liste des structures de la franchise et les droits
      $structures = $franchise->getStructures();
      $structuresDroits = $structure->getStructuresDroits();
      
      return $this->render('franchises/details.html.twig', compact('franchise', 'structures', 'structuresDroits'));
    }
}
