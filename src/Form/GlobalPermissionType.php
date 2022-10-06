<?php

namespace App\Form;

use App\Entity\Droits;
use App\Entity\Franchises;
use App\Entity\StructuresDroits;
use App\Repository\DroitsRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class GlobalPermissionType extends AbstractType
{
  /**
   * {@inheritDoc}
   */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
      $builder
        ->add('franchise', EntityType::class, [
          'class' => Franchises::class,
          'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('f')
              ->orderBy('f.name', 'ASC');
          },
          'choice_label' => 'name',
        ])
        ->add('status', ChoiceType::class, [
          'choices' => [
            'Actif' => 1,
            'Inactif' => 0
          ]
        ])
        ->add('droits', EntityType::class, [
          'class' => Droits::class,
          'choice_label' => 'name',
          'query_builder' => function(DroitsRepository $repository) {
          return $repository->createQueryBuilder('d')->orderBy('d.id', 'ASC');
          },
          'constraints' => new NotBlank(['message' => 'veuillez choisir une permission'])
        ])
        ->add('submit', SubmitType::class, [
          'attr' => [
            'class' => 'btn btn-warning btn-lg'
          ],
          'label' => 'Ajouter'
        ])
      ;
    }

/*->add('submit', SubmitType::class)

if ( $form->isSubmitted() && $form->isValid()) {
$this->em->persist($franchiseForm);
$this->em->flush();

return $this->redirectToRoute('franchises_droits');
}*/

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StructuresDroits::class,
        ]);
    }
}
