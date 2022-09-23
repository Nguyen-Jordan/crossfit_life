<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/partenaire', name: 'partenaire_')]
class PartenaireController extends AbstractController
{
  #[Route('/', name: 'index')]
  public function index(): Response
  {
   
    return $this->render('partner/index.html.twig');
  }
  
}