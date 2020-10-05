<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Redacteur;
use App\Entity\Rubrique;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,['label'=>'Nom'])
            ->add('contenu',TextareaType::class,['label'=>'Contenu'])
            ->add('auteur',EntityType::class,[
                'class'=>Redacteur::class,
                'choice_label'=>'pseudo'
            ])
            ->add('idRubrique',EntityType::class,[
                'class'=>Rubrique::class,
                'choice_label'=>'nom'
            ])
            ->add('save',SubmitType::class,['label'=>'Valider'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
