<?php
// src/Form/NewsType.php

namespace App\Form;


use App\Entity\Account;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterAccountByState extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('search', TextType::class, [
                'required' => true,
                'label' => 'State',
                'attr' => [
                    'class' => 'w-full px-5 py-2 text-gray-700 bg-gray-200 rounded',
                    'placeholder' => 'search',
                ],
                'label_attr' => [
                    'class' => 'block text-sm text-gray-600',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options if needed
        ]);
    }
}

?>