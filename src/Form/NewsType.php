<?php
// src/Form/NewsType.php

namespace App\Form;


use App\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', TextType::class, [
                'required' => false,
                 'label' => '',
                'attr' => [
               
                    'placeholder' => '','hidden' => ''
                ],
                 
            ])
            ->add('text', TextareaType::class, [
                'required' => true,
                'label' => 'Message',
                'attr' => [
                    'class' => 'w-full px-5 py-2 text-gray-700 bg-gray-200 rounded',
                    'placeholder' => 'Text',
                ],
                'label_attr' => [
                    'class' => 'block text-sm text-gray-600',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => News::class,
            
        ]);
    }
}

?>