<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => [
                    'placeholder' => "Saisir le titre l'article "
                ]
            ])

            ->add('contenu', TextareaType::class, [
                     'label' => 'Contenu article',
                    'attr' => [
                    'placeholder' => "saisir le contenu de l'article ",
                     'rows' => 10
                ]
            ])
            ->add('image', TextType::class, [
                'attr' => [
                    'placeholder' => "saisir l'url de l'image "
                ]
            ]);

            // ->add('date')
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
