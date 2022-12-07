<?php

namespace App\Form;

use App\Entity\Franchises;
use App\Entity\Users;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FranchiseType extends AbstractType
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
              'label' => 'Permissions globales',
              'entry_options' => [
                'attr' => ['class' => 'form-select'],
                'label' => false
              ],
              'by_reference' => false,
              'allow_add' => true,
              'allow_delete' => true
            ])
            ->add('submit', SubmitType::class, [
              'attr' => [
                'class' => 'btn btn-lg btn-warning my-2'
              ],
            'label' => 'Ajouter'
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
