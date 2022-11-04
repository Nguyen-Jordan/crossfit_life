<?php

namespace App\Controller;

use App\Entity\Franchises;
use App\Entity\StructuresDroits;
use App\Form\EditFranchiseType;
use App\Form\FranchiseType;
use App\Repository\FranchisesRepository;
use App\Repository\StructuresDroitsRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/franchises', name: 'franchises_')]
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

  public function __construct(private SluggerInterface $slugger){}

  /**
   * @param Request $request
   * @return Response
   */
    #[Route('/ajout', name: 'ajout')]
    public function ajoutFranchise(
      Request $request,
      EntityManagerInterface $em,
      SendMailService $mail
    ): Response
    {
      $franchiseForm = new Franchises();

      $form = $this->createForm(FranchiseType::class, $franchiseForm);

      $form->handleRequest($request);

      if ( $form->isSubmitted() && $form->isValid()) {
        $permissions = $form->get('structuresDroits')->getData();
        $user = $form->get('user')->getData();

        foreach ($permissions as $permission){
          $franchiseForm->addStructuresDroit($permission);
        }
        $franchiseForm->setSlug($this->slugger->slug($franchiseForm->getName())->lower());

        $em->persist($franchiseForm);
        $em->flush();

        // J'envoie un mail de creation
        $mail->send(
          'no-reply@crossfitlife.com',
          $user->getEmail(),
          'Activation de la franchise',
          'createFranchise',
          compact('user', 'franchiseForm')
        );

        $this->addFlash('success', 'Franchise inscrite avec succès');
        return $this->redirectToRoute('franchises_index');
      }

      return $this->render('admin/franchises/ajout.html.twig', [
        'form_add_franchise' => $form->createView()
      ]);
    }


    #[Route('/modifier/{slug}', name: 'modifier')]
    public function modifierFranchise(
      string $slug,
      Franchises $franchises,
      Request $request,
      EntityManagerInterface $em,
      SendMailService $mail
    ): Response
    {
      $form = $this->createForm(EditFranchiseType::class, $franchises);
      $form->handleRequest($request);

      if ( $form->isSubmitted() && $form->isValid()) {
        $user = $form->get('user')->getData();

        $em->persist($franchises);
        $em->flush();

        // J'envoie un mail de modification
        $mail->send(
          'no-reply@crossfitlife.com',
          $user->getEmail(),
          'Modification de la franchise',
          'modifyFranchise',
          compact('user', 'franchises')
        );

        $this->addFlash('success', 'Franchise modifiée avec succès');
        return $this->redirectToRoute('franchises_index');
      }

      return $this->render('admin/franchises/global.html.twig', [
        'form_edit_franchise' => $form->createView(),
        'slug' => $slug,
        'franchises' => $franchises
      ]);
    }

    #[Route('/{slug}', name: 'details')]
    public function details(
      string $slug,
      StructuresDroitsRepository $repository,
      Franchises $franchises
    ): Response
    {

      return $this->render('admin/franchises/details.html.twig', [
        'slug' => $slug,
        'result' => $repository->findAll(),
        'franchise' => $franchises
      ]);
    }

    #[Route('/activer/{id}', name: 'activate')]
    public function activate(Franchises $franchise, EntityManagerInterface $em)
    {
      $franchise->setStatus(($franchise->isStatus())?false:true);
      $em->persist($franchise);
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

      return $this->redirectToRoute('franchises_details', [
        'slug' => $slug
      ]);
    }

    #[Route('/activer/globalPermission/{id}/{slug}', name: 'activer_global_permission')]
    public function activerGlobalPermission(
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

      return $this->redirectToRoute('franchises_modifier', [
        'slug' => $slug
      ]);
    }

    #[Route('/permissions/activer/{id}', name: 'activate_status')]
    public function activateStatus(Franchises $franchises, EntityManagerInterface $em)
    {
      $structuresDroits = $franchises->getStructuresDroits();
      foreach ($structuresDroits as $structuresDroit){
        $structuresDroit->setStatus(($structuresDroit->isStatus())?false:true);

        $em->persist($structuresDroit);
        $em->flush();
      }

      return new Response("true");
    }

    #[Route('/supprimer/{id}', name: 'delete')]
    public function delete(
      Request $request,
      Franchises $franchise,
      EntityManagerInterface $em
    ): Response
    {
      $submittedToken = $request->request->get('token');

      if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {
        $em->remove($franchise);
        $em->flush();

        $this->addFlash('success', 'Franchise supprimée avec succès');
      }

      return $this->redirectToRoute('franchises_index');
    }
}
