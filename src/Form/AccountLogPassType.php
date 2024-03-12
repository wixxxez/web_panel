<?php
// src/Form/NewsType.php

namespace App\Form;


use App\Entity\Account;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountLogPassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', TextType::class, [
                'required' => true,
                'label' => 'Login',
                'attr' => [
                    'class' => 'w-full px-5 py-2 text-gray-700 bg-gray-200 rounded',
                    'placeholder' => 'login',
                ],
                'label_attr' => [
                    'class' => 'block text-sm text-gray-600',
                ],
            ])
            ->add('password', TextType::class, [
                'required' => true,
                'label' => 'Password',
                'attr' => [
                    'class' => 'w-full px-5 py-2 text-gray-700 bg-gray-200 rounded',
                    'placeholder' => 'password',
                ],
                'label_attr' => [
                    'class' => 'block text-sm text-gray-600',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Account::class,
            
        ]);
    }
}

?>