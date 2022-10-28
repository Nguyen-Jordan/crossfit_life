<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
  #[Route('/main', name: 'main')]
  public function index(): Response
  {
      
      return $this->render('main/index.html.twig');
  }

  #[Route('/main/Mentions-légales', name: 'legal_mention')]
  public function legalMention(): Response
  {

    return $this->render('main/legalMention.html.twig');
  }
}
