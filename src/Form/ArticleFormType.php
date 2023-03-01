<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class, ['attr'=>['class'=>'form-control'],'label' => 'Article Name' ])
            ->add('Price', IntegerType::class, ['attr'=>['class'=>'form-control'],'label' => 'Price (FCFA)' ])
            ->add('Description', TextType::class, ['attr'=>['class'=>'form-control'],'label' => 'Description' ])
            ->add('available', TextType::class, ['attr'=>['class'=>'form-control'],'label' => 'Available' ])
            ->add('category', EntityType::class, ['class' => Category::class,
                                                    'choice_label'=> 'Name',
                                                    'attr'=>['class'=>'form-control'],
                                                    'label' => 'Category-ID' ] )
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
