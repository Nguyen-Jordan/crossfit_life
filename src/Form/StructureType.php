<?php

namespace App\Form;

use App\Entity\Droits;
use App\Entity\Franchises;
use App\Entity\Structures;
use App\Entity\StructuresDroits;
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
        ->add('slug', TextType::class, [
          'attr' => [
            'class' => 'form-control'
          ],
          'label' => 'Adresse dans l\'onglet: '
        ] )
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
        ->add('structuresDroits', ChoiceType::class, [
          'placeholder' => 'Droit (choisir les droits)',
          'label' => 'Les permissions global: '
        ])
        ->add('submit', SubmitType::class, [
          'attr' => [
            'class' => 'btn btn-warning btn-lg'
          ],
          'label' => 'Ajouter'
        ])
      ;

      $formModifier = function (FormInterface $form, Franchises $franchise = null){
        $structuresDroits = (null === $franchise) ? [] : $franchise->getStructuresDroits();

        $form->add('structuresDroits', EntityType::class, [
          'class' => StructuresDroits::class,
          'mapped' => false,
          'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('sd')
              ->join('sd.droits', 'd')
              ->orderBy('d.name', 'ASC');
          },
          'choices' => $structuresDroits,
          'choice_label' => 'status',
          'placeholder' => 'Droit (choisir les droits)',
          'label' => 'Les permissions global'
        ]);
      };

      $builder->get('franchise')->addEventListener(
        FormEvents::POST_SUBMIT,
        function (FormEvent $event) use ($formModifier){
          $franchise = $event->getForm()->getData();
          $formModifier($event->getForm()->getParent(), $franchise);
        }
      );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
      $resolver->setDefaults([
        'data_class' => Structures::class,
      ]);
    }
}
