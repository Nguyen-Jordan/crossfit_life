<?php

namespace App\Controller;

use App\Entity\Franchises;
use App\Entity\Structures;
use App\Form\StructureType;
use App\Repository\FranchisesRepository;
use App\Repository\StructuresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/structures', name: 'structures_')]
class StructuresController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(StructuresRepository $structuresRepository): Response
    {
        return $this->render('admin/structures/index.html.twig', [
            'structures' => $structuresRepository->findBy([],
              ['id' => 'asc'])
        ]);
    }

    private EntityManagerInterface $em;

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
    public function ajoutStructure(
      Request $request,
      FranchisesRepository $repository
    ): Response
    {
      $post = new Structures();
      $form = $this->createForm(StructureType::class, $post);
      $form->handleRequest($request);

      if ( $form->isSubmitted() && $form->isValid()) {
        // $franchise = $repository->findOneBy($form->get('franchise')->getData());
        // /**
        // * @var Franchises
        // */

        // $droit = $franchise->getStructuresDroits();

        // il faut importerter les fichier repository franchiseRepository
        // getter l'id franchise dans le formulaire , form get datda + get('franchise')
        // annotation var $franchise pour dir ec'est une entite franchise
        // cette entite franchise on fait getter droit sur getStructuresDroits et on bouche dessue pour setter dans structure et on persist
        
        $this->em->persist($post);
        $this->em->flush();
        return $this->redirectToRoute('structures_ajout');

      }
      return $this->render('admin/structures/ajout.html.twig', [
        'form_add_structure' => $form->createView()
      ]);
    }

    #[Route('/modifier', name: 'modifier')]
    public function modifierStructure(Structures $structures, Request $request): Response
    {
      $form = $this->createForm(StructureType::class, $structures);
      $form->handleRequest($request);

      if ( $form->isSubmitted() && $form->isValid()) {
        $this->em->persist($structures);
        $this->em->flush();
        return $this->redirectToRoute('structures_ajout');

      }
      return $this->render('admin/structures/ajout.html.twig', [
        'form_add_structure' => $form->createView()
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

      return $this->render('admin/structures/details.html.twig', [
        'result' => $result,
        'structure' => $structures
      ]);
    }
}
