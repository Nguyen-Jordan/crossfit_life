<?php

namespace App\Controller;

use App\Entity\Franchises;
use App\Entity\Structures;
use App\Repository\FranchisesRepository;
use App\Repository\StructuresRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/partenaire', name: 'partenaire_')]
class PartenaireController extends AbstractController
{
  #[Route('/', name: 'index')]
  public function index(Structures $structures): Response
  {
    //On va chercher la liste des droits
   
    return $this->render('partner/index.html.twig', [
    
    ]);
  }
  
}