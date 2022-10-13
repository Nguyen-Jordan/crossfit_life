<?php

namespace App\Form;

use App\Entity\Droits;
use App\Entity\Franchises;
use App\Entity\StructuresDroits;
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
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
      $builder
        ->add('droits', EntityType::class, [
          'class' => Droits::class,
          'query_builder' => function(EntityRepository $repository) {
            return $repository->createQueryBuilder('d')
              ->orderBy('d.name', 'ASC');
          },
          'multiple' => true,
          'expanded' => true,
          'choice_label' => 'name',
          'constraints' => new NotBlank(['message' => 'veuillez choisir une permission']),
          'label' => 'Permission: '
        ])
        ->add('status', ChoiceType::class, [
          'choices' => [
            'Actif' => 1,
            'Inactif' => 0
          ], 'attr' => [
            'class' => 'form-control'
          ],
          'label' => 'statut: '
        ])

      ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StructuresDroits::class,
        ]);
    }
}

