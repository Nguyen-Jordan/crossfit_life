<?php

namespace App\Form;

use App\Entity\Franchises;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FranchiseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
              'attr' => [
                'class' => 'form-control'
              ],
              'label' => 'Ville: '
            ])
            ->add('status', ChoiceType::class, [
              'choices' => [
                'Actif' => 1,
                'Inactif' => 0
              ], 'attr' => [
                'form-control'
              ],
              'label' => 'Statut: '
            ])
            ->add('structuresDroits', CollectionType::class, [
              'entry_type' => GlobalPermissionType::class,
              'mapped' => false,
              'entry_options' => [
                'label' => false
              ],
              'by_reference' => false,
              'allow_add' => true,
              'allow_delete' => true
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
