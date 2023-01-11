<?php

namespace App\Controller;

use App\Entity\Droits;
use App\Form\DroitsType;
use App\Repository\DroitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/droits', name: 'droits_')]
class DroitsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(DroitsRepository $droitsRepository): Response
    {
        return $this->render('admin/droits/index.html.twig', [
          'droits' => $droitsRepository->findBy([],
            ['id' => 'asc'])
        ]);
    }

  #[Route('/ajout', name: 'add')]
  public function ajout(
    Request $request,
    EntityManagerInterface $em
  ): Response
  {
    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    $droit = new Droits();

    $droitForm = $this->createForm(DroitsType::class, $droit);
    $droitForm->handleRequest($request);

    if ( $droitForm->isSubmitted() && $droitForm->isValid()){
      $em->persist($droit);
      $em->flush();

      $this->addFlash('success', 'Droit ajouté avec succès');
      return $this->redirectToRoute('droits_index');
    }

    return $this->render('admin/droits/ajoutDroit.html.twig', [
      'droitForm' => $droitForm->createView()
    ]);
  }

  #[Route('/modifier/{id}', name: 'modify')]
  public function edit(
    Droits $droit,
    Request $request,
    EntityManagerInterface $em
  ): Response
  {
    $this->denyAccessUnlessGranted('ROLE_ADMIN');

    $droitForm = $this->createForm(DroitsType::class, $droit);
    $droitForm->handleRequest($request);

    if ( $droitForm->isSubmitted() && $droitForm->isValid()){
      $em->persist($droit);
      $em->flush();

      $this->addFlash('success', 'Droit modifiée avec succès');
      return $this->redirectToRoute('droits_index');
    }

    return $this->render('admin/droits/edit.html.twig', [
      'droitForm' => $droitForm->createView()
    ]);
  }

  #[Route('/supprimer/{id}', name: 'delete')]
  public function delete(
    Request $request,
    Droits $droits,
    EntityManagerInterface $em
  ): Response
  {
    $submittedToken = $request->request->get('token');

    if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {

      $em->remove($droits);
      $em->flush();

      $this->addFlash('success', 'Droit supprimée avec succès');
    }

    return $this->redirectToRoute('droits_index');
  }
}
