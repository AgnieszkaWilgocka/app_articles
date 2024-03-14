<?php

namespace App\Form\Type;

use App\Entity\Article;
use App\Entity\Author;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'title',
                'required' => true,
            ]
            );
            
        $builder->add(
            'text',
            TextType::class,
            [
                'label' => 'text',
                'required' => true,
            ]
            );
        $builder->add(
            'authors',
            EntityType::class,
            [
                'class' => Author::class,
                'choice_label' => function($author): string {
                    return $author->getName();
                },
                'label' => 'label.author',
                'placeholder' => 'label.none',
                'required' => true,
                'multiple' => true,
                'expanded' => true
            ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Article::class
            ]
            );
        
    }
}











?>