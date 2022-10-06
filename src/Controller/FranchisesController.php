<?php

namespace App\Controller;

use App\Entity\Franchises;
use App\Entity\StructuresDroits;
use App\Form\FranchiseType;
use App\Form\GlobalPermissionType;
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

      $franchiseForm->setName('Pinto');

      $droits = new StructuresDroits();
      $droits->setDroits(NULL);
      $droits->setStatus(1);
      $droits->setFranchise($franchiseForm);

      $franchiseForm->addStructuresDroit($droits);

      dump($franchiseForm);

      $form->handleRequest($request);

      if ($form->isSubmitted()) {
        dump($franchiseForm);
      }


      return $this->render('admin/franchises/ajout.html.twig', [
        'form_add_franchise' => $form->createView()
      ]);
    }

    #[Route('/ajout/droits', name: 'droits')]
    public function droitsFranchise(Request $request): Response
    {
      $globalPermission = new StructuresDroits();
      $form = $this->createForm(GlobalPermissionType::class, $globalPermission);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $this->em->persist($globalPermission);
        $this->em->flush();

        return $this->redirectToRoute('franchises_droits');
      }
      return $this->render('admin/franchises/global.html.twig', [
        'form_add_global_permission' => $form->createView()
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
