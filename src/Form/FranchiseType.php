<?php

namespace App\Form;

use App\Entity\Franchises;
use App\Form\GlobalPermissionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FranchiseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('status', ChoiceType::class, [
              'choices' => [
                'Actif' => 1,
                'Inactif' => 0
              ]
            ])
            ->add('slug')
            ->add('structuresDroits', CollectionType::class, [
              'entry_type' => GlobalPermissionType::class,
              'label' => 'Permission: ',
              'mapped' => false,
              'entry_options' => [
                'label' => false
              ],
              'by_reference' => false,
              'allow_add' => true,
              'allow_delete' => true
            ])
            ->add('save', SubmitType::class, [
              'label' => 'Soumettre',
              'attr' => [
                'class' => 'btn btn-warning'
              ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Franchises::class,
        ]);
    }
}
