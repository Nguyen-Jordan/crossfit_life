<?php

namespace App\Controller;

use App\Entity\Franchises;
use App\Entity\Structures;
use App\Entity\StructuresDroits;
use App\Form\StructureType;
use App\Repository\StructuresRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/structures', name: 'structures_')]
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
      EntityManagerInterface $em,
      SendMailService $mail
    ): Response
    {
      $structureForm = new Structures();
      $form = $this->createForm(StructureType::class, $structureForm);
      $form->handleRequest($request);

      if ( $form->isSubmitted() && $form->isValid()) {
        // On ajoute les droits de la franchise associe à la structure
        /**
         * @var Franchises $franchise
         */
         $franchise = $form->get('franchise')->getData();
         $structureDroits = $franchise->getStructuresDroits();
         $userStructure = $form->get('user')->getData();
         $userFranchise = $franchise->getUser();

         foreach ($structureDroits as $structureDroit){
           /**
            * @var StructuresDroits $structureDroit
            */
           $sd = new StructuresDroits();
           $sd->setDroits($structureDroit->getDroits());
           $sd->setStatus($structureDroit->isStatus());
           $sd->setStructures($form->getData());
           $structureForm->addStructuresDroit($sd);
         }
        $structureForm->setSlug($this->slugger->slug($structureForm->getAddress())->lower());

        $em->persist($structureForm);
        $em->flush();


        // J'envoie un mail de creation au manager
        $mail->send(
          'no-reply@crossfitlife.com',
          $userStructure->getEmail(),
          'Activation de la Structure',
          'createStructure',
          compact('userStructure', 'structureForm')
        );

        // J'envoie un mail de creation au partenaire
        $mail->send(
          'no-reply@crossfitlife.com',
          $userFranchise->getEmail(),
          'Activation de la Structure',
          'createStructure',
          compact('userStructure', 'structureForm')
        );

        $this->addFlash('success', 'Structure inscrite avec succès');
        return $this->redirectToRoute('structures_index');
      }
      return $this->render('admin/structures/ajout.html.twig', [
        'form_add_structure' => $form->createView()
      ]);
    }

    #[Route('/modifier/{id}', name: 'modifier')]
    public function modifierStructure(
      Structures $structures,
      Request $request,
      EntityManagerInterface $em,
      SendMailService $mail
    ): Response
    {
      $form = $this->createForm(StructureType::class, $structures);
      $form->handleRequest($request);

      if ( $form->isSubmitted() && $form->isValid()) {
        $franchise = $form->get('franchise')->getData();
        $userStructure = $form->get('user')->getData();
        $userFranchise = $franchise->getUser();

        $em->persist($structures);
        $em->flush();

        // J'envoie un mail de modification au manager
        $mail->send(
          'no-reply@crossfitlife.com',
          $userStructure->getEmail(),
          'Modification de la Structure',
          'modifyStructure',
          compact('userStructure', 'structures')
        );

        // J'envoie un mail de modification au partenaire
        $mail->send(
          'no-reply@crossfitlife.com',
          $userFranchise->getEmail(),
          'Modification de la Structure',
          'modifyStructure',
          compact('userStructure', 'structures')
        );

        $this->addFlash('success', 'Structure modifiée avec succès');
        return $this->redirectToRoute('structures_index');
      }

      return $this->render('admin/structures/modify.html.twig', [
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

    #[Route('/supprimer/{id}', name: 'delete')]
    public function delete(Structures $structure, EntityManagerInterface $em)
    {
      $em->remove($structure);
      $em->flush();

      $this->addFlash('success', 'Structure supprimée avec succès');
      return $this->redirectToRoute('structures_index');
    }
}
