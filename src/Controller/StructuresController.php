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
        return $this->render('pages/structures/index.html.twig', [
            'structures' => $structuresRepository->findBy([],
              ['id' => 'asc'])
        ]);
    }
    
    #[Route('/{slug}', name: 'details')]
    public function details(
      StructuresRepository $structure,
      Structures $structures
    ): Response
    {
      //On va chercher la liste des droits
      $result = $structure->findRights([$structures],['id' => 'asc']);
      
      return $this->render('pages/structures/details.html.twig', [
        'result' => $result,
        'structure' => $structures
      ]);
    }
}
