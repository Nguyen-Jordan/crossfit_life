<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
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
            ->add('roles', ChoiceType::class, [
              'required' => true,
              'multiple' => false,
              'expanded' => false,
              'choices' => [
                'Manager' => "ROLE_MANAGER",
                'Partner' => "ROLE_PARTNER",
                'Admin' => "ROLE_ADMIN",
              ]
            ])
            ->add('email', EmailType::class, [
              'attr' => [
                'class' => 'form-control'
              ],
              'label' => 'E-mail'
            ])
            ->add('firstname', TextType::class, [
              'attr' => [
                'class' => 'form-control'
              ],
              'label' => 'Prénom'
            ])
            ->add('lastname', TextType::class, [
              'attr' => [
                'class' => 'form-control'
              ],
              'label' => 'Nom'
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'label' => 'Mot de passe: ',
                'attr' => [
                  'autocomplete' => 'new-password',
                  'class' => 'form-control'
                ],
              'constraints' => [
                new Regex('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
                  "Le mot de passe doit contenir au minimum 8 caractères avec une minuscule, une majuscule, un caractère spécial et un chiffre.")
              ],
            ])
        ;
        $builder->get('roles')
          ->addModelTransformer(new CallbackTransformer(
            function ($rolesArray) {
              // transform the array to a string
              return count($rolesArray)? $rolesArray[0]: null;
            },
            function ($rolesString) {
              // transform the string back to an array
              return [$rolesString];
            }
          ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
