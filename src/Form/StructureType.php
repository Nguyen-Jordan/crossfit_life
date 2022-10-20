<?php

namespace App\Form;

use App\Entity\Droits;
use App\Entity\Franchises;
use App\Entity\Structures;
use App\Entity\StructuresDroits;
use App\Entity\Users;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StructureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
      $builder
        ->add('user', EntityType::class, [
          'class' => Users::class,
          'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('u')
              ->orderBy('u.email', 'ASC');
          },
          'attr' => [
            'class' => 'form-select'
          ],
          'choice_label' => 'email',
          'label' => 'Utilisateur propriétaire: '
        ])
        ->add('status', ChoiceType::class, [
          'choices' => [
            'Actif' => 1,
            'Inactif' => 0
          ]
        ])
        ->add('address', TextType::class, [
          'attr' => [
            'class' => 'form-control'
          ],
          'label' => 'Adresse de la structure: '
        ])
        ->add('franchise', EntityType::class, [
          'class' => Franchises::class,
          'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('f')
              ->orderBy('f.name', 'ASC');
          },
          'attr' => [
            'class' => 'form-select'
          ],
          'choice_label' => 'name',
          'label' => 'Franchise liée: '
        ])
      ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
      $resolver->setDefaults([
        'data_class' => Structures::class,
      ]);
    }
}
