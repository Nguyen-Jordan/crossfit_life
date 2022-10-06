<?php

namespace App\Form;

use App\Entity\Franchises;
use App\Entity\StructuresDroits;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
              'mapped' => false,
              'entry_options' => [
                'label' => false
              ],
              'by_reference' => false,
              'allow_add' => true,
              'allow_delete' => true
            ])
            /*->add('structuresDroits', EntityType::class, [
              'class' => StructuresDroits::class,
              'mapped' =>false,
              'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('sd')
                  ->select('d.name, sd.status')
                  ->join('sd.droits', 'd')
                  ->where('sd.droits = d.id')
                  ->orderBy('d.id', 'ASC');
              },
              'choice_label' => 'name',
            ])*/
            ->add('save', SubmitType::class, [
              'attr' => [
                'class' => 'btn btn-success'
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
