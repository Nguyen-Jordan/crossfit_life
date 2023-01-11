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

   #[Route('/ajout', name: 'add')]
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
        $structureForm->setSlug(
          $this->slugger->slug($structureForm->getAddress())->lower()
        );

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

    #[Route('/activer/permission/{id}/{slug}', name: 'activer_permission')]
    public function activerPermission(
      string $slug,
      Request $request,
      StructuresDroits $structuresDroits,
      EntityManagerInterface $em
    )
    {
      $submittedToken = $request->request->get('token');

      if ($this->isCsrfTokenValid('modify_item', $submittedToken)) {
        $newDroit = !$structuresDroits->isStatus();
        $structuresDroits->setStatus($newDroit);

        $em->persist($structuresDroits);
        $em->flush();
      }

      return $this->redirectToRoute('structures_details', [
        'slug' => $slug
      ]);
    }

    #[Route('/{slug}', name: 'details')]
    public function details(
      string $slug,
      StructuresRepository $structure,
      Structures $structures
    ): Response
    {
      //On va chercher la liste des droits
      $result = $structure->findRights([$structures],['id' => 'asc']);

      return $this->render('admin/structures/details.html.twig', [
        'result' => $result,
        'slug' => $slug,
        'structure' => $structures
      ]);
    }

    #[Route('/supprimer/{id}', name: 'delete')]
    public function delete(
      Request $request,
      Structures $structure,
      EntityManagerInterface $em
    ): Response
    {
      $submittedToken = $request->request->get('token');
      if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {

        $em->remove($structure);
        $em->flush();

        $this->addFlash('success', 'Structure supprimée avec succès');
      }

      return $this->redirectToRoute('structures_index');
    }
}
