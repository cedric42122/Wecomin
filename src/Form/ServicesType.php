<?php

namespace App\Form;

use App\Entity\ServiceDelivery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServicesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextareaType::class)
            ->add('picture', FileType::class, array(
                'data_class' => null,
                'attr' =>
                [
                    'placeholder' => 'Choose a file',
                ]
                ))
            ->add('price', MoneyType::class)
            ->add('promotion');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            
            'data_class' => ServiceDelivery::class,
        ]);
    }
}
