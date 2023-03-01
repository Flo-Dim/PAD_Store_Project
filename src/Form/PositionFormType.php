<?php

namespace App\Form;

use App\Entity\Position;
use App\Entity\Budget;
use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PositionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['attr'=>['class'=>'form-control'],'label' => 'Title' ])
            ->add('users',EntityType::class, ['class' => User::class,
                                              'choice_label'=> 'id',
                                              'attr'=>['class'=>'form-control'],
                                              'label' => 'User-ID' ])
            ->add('budget',EntityType::class, ['class' => Budget::class,
                                                'choice_label'=> 'Amount',
                                               'attr'=>['class'=>'form-control'],
                                               'label' => 'Budget (FCFA)' ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Position::class,
        ]);
    }
}
