<?php

namespace App\Controller;

use App\Entity\Structures;
use App\Repository\StructuresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/structures', name: 'structures_')]
class StructuresController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(StructuresRepository $structuresRepository): Response
    {
        return $this->render('structures/index.html.twig', [
            'structures' => $structuresRepository->findBy([],
              ['id' => 'asc'])
        ]);
    }
  
    #[Route('/{slug}', name: 'details')]
    public function details(Structures $structure): Response
    {
      //On va chercher la liste des droits
      $rights = $structure->getStructuresDroits();
      
      return $this->render('structures/details.html.twig', compact('structure', 'rights'));
    }
}
