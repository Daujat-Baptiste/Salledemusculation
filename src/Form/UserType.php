<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Rédacteur' => 'ROLE_REDACTOR',
                    'Admin' => 'ROLE_ADMIN'
                ],
                'expanded' =>true,
                'multiple' => true,
                'label'=> 'Rôles'
            ])
            ->add('prenom')
            ->add('nom')
            ->add('sexe', ChoiceType::class, ['choices' =>
                ['Homme' => true,
                    'Femme' => false,
                ]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
