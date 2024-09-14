<?php
 

namespace App\Form;


use App\Entity\Account;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoggedAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('event', TextType::class, [
                'required' => false,
                'label' => 'Event',
                'attr' => [
                    'class' => 'w-full px-5 py-2 text-gray-700 bg-gray-200 rounded',
                    'placeholder' => 'event',
                ],
                'label_attr' => [
                    'class' => 'block text-sm text-gray-600',
                ],
            ])
            ->add('date', TextType::class, [
                'required' => true,
                'label' => 'Date',
                'attr' => [
                    'class' => 'w-full px-5 py-2 text-gray-700 bg-gray-200 rounded',
                    'placeholder' => 'date',
                ],
                'label_attr' => [
                    'class' => 'block text-sm text-gray-600',
                ],
            ])
            ->add('barcode1', TextType::class, [
                'required' => true,
                'label' => 'Barcode1',
                'attr' => [
                    'class' => 'w-full px-5 py-2 text-gray-700 bg-gray-200 rounded',
                    'placeholder' => 'barcode',
                ],
                'label_attr' => [
                    'class' => 'block text-sm text-gray-600',
                ],
            ])
            ->add('barcode2', TextType::class, [
                'required' => true,
                'label' => 'Barcode2',
                'attr' => [
                    'class' => 'w-full px-5 py-2 text-gray-700 bg-gray-200 rounded',
                    'placeholder' => 'barcode',
                ],
                'label_attr' => [
                    'class' => 'block text-sm text-gray-600',
                ],
            ])
            ->add('price', TextType::class, [
                'required' => true,
                'label' => 'Price (USD)',
                'attr' => [
                    'class' => 'w-full px-5 py-2 text-gray-700 bg-gray-200 rounded',
                    'placeholder' => 'Price in usd',
                ],
                'label_attr' => [
                    'class' => 'block text-sm text-gray-600',
                ],
            ])
            ->add('seats', TextType::class, [
                'required' => false,
                'label' => 'Seats',
                'attr' => [
                    'class' => 'w-full px-5 py-2 text-gray-700 bg-gray-200 rounded',
                    'placeholder' => 'seats',
                ],
                'label_attr' => [
                    'class' => 'block text-sm text-gray-600',
                ],
            ])
            ->add('barcode3', TextType::class, [
                'required' => false,
                'label' => 'Barcode3',
                'attr' => [
                    'class' => 'w-full px-5 py-2 text-gray-700 bg-gray-200 rounded',
                    'placeholder' => 'barcode',
                ],
                'label_attr' => [
                    'class' => 'block text-sm text-gray-600',
                ],
            ])
            ->add('barcode4', TextType::class, [
                'required' => false,
                'label' => 'Barcode4',
                'attr' => [
                    'class' => 'w-full px-5 py-2 text-gray-700 bg-gray-200 rounded',
                    'placeholder' => 'barcode',
                ],
                'label_attr' => [
                    'class' => 'block text-sm text-gray-600',
                ],
            ])
            ->add('price2', TextType::class, [
                'required' => false,
                'label' => 'Price (USD)',
                'attr' => [
                    'class' => 'w-full px-5 py-2 text-gray-700 bg-gray-200 rounded',
                    'placeholder' => 'Price in usd',
                ],
                'label_attr' => [
                    'class' => 'block text-sm text-gray-600',
                ],
            ])
            ->add('seats2', TextType::class, [
                'required' => false,
                'label' => 'Seats',
                'attr' => [
                    'class' => 'w-full px-5 py-2 text-gray-700 bg-gray-200 rounded',
                    'placeholder' => 'seats',
                ],
                'label_attr' => [
                    'class' => 'block text-sm text-gray-600',
                ],
            ])
            ;


             
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Account::class,
            
        ]);
    }
}

?>