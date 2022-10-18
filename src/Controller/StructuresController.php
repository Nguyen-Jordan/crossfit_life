<?php

namespace App\Controller;

use App\Entity\Droits;
use App\Entity\Franchises;
use App\Entity\Structures;
use App\Entity\StructuresDroits;
use App\Form\StructureType;
use App\Repository\StructuresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

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

    public function __construct(private SluggerInterface $slugger){}

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/ajout', name: 'ajout')]
    public function ajoutStructure(
      Request $request,
      EntityManagerInterface $em
    ): Response
    {
      $post = new Structures();
      $form = $this->createForm(StructureType::class, $post);
      $form->handleRequest($request);

      if ( $form->isSubmitted() && $form->isValid()) {
        // On ajoute les droits de la franchise associe à la structure
        /**
         * @var Franchises $franchise
         */
         $franchise = $form->get('franchise')->getData();
         $structureDroits = $franchise->getStructuresDroits();

         foreach ($structureDroits as $structureDroit){
           /**
            * @var StructuresDroits $structureDroit
            */
           $sd = new StructuresDroits();
           $sd->setDroits($structureDroit->getDroits());
           $sd->setStatus($structureDroit->isStatus());
           $sd->setStructures($form->getData());
           $post->addStructuresDroit($sd);
         }
        $post->setSlug($this->slugger->slug($post->getAddress())->lower());

        $em->persist($post);
        $em->flush();

        $this->addFlash('success', 'Structure ajouté avec succès');
        return $this->redirectToRoute('structures_index');
      }
      return $this->render('admin/structures/ajout.html.twig', [
        'form_add_structure' => $form->createView()
      ]);
    }

    #[Route('/modifier', name: 'modifier')]
    public function modifierStructure(
      Structures $structures,
      Request $request,
      EntityManagerInterface $em): Response
    {
      $form = $this->createForm(StructureType::class, $structures);
      $form->handleRequest($request);

      if ( $form->isSubmitted() && $form->isValid()) {
        $em->persist($structures);
        $em->flush();

        return $this->redirectToRoute('structures_ajout');
      }

      return $this->render('admin/structures/ajout.html.twig', [
        'form_add_structure' => $form->createView()
      ]);
    }

    #[Route('/activer/{id}', name: 'activer')]
    public function activer(Structures $structures, EntityManagerInterface $em)
    {
        $structures->setStatus(($structures->isStatus())?false:true);

        $em->persist($structures);
        $em->flush();

        return new Response("true");
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
