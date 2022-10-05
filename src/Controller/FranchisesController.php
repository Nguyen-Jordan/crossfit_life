<?php

namespace App\Controller;

use App\Entity\Franchises;
use App\Entity\StructuresDroits;
use App\Form\FranchiseType;
use App\Repository\FranchisesRepository;
use App\Repository\StructuresDroitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    private $em;

    /**
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
      $this->em = $em;
    }

  /**
   * @param Request $request
   * @return Response
   */
    #[Route('/ajout', name: 'ajout')]
    public function ajoutFranchise(Request $request): Response
    {
      $franchiseForm = new Franchises();
      $form = $this->createForm(FranchiseType::class, $franchiseForm);
      $form->handleRequest($request);

      if ( $form->isSubmitted() && $form->isValid()) {
        $this->em->persist($franchiseForm);
        $this->em->flush();
        return $this->redirectToRoute('franchises_ajout');

      }
      return $this->render('admin/franchises/ajout.html.twig', [
        'form_add_franchise' => $form->createView()
      ]);
    }

    #[Route('/modifier/{id}', name: 'modifier')]
    public function modifierFranchise(Franchises $franchises, Request $request): Response
    {
      $form = $this->createForm(FranchiseType::class, $franchises);
      $form->handleRequest($request);

      if ( $form->isSubmitted() && $form->isValid()) {
        $this->em->persist($franchises);
        $this->em->flush();
        return $this->redirectToRoute('franchises_ajout');

      }
      return $this->render('admin/franchises/ajout.html.twig', [
        'form_add_franchise' => $form->createView()
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
