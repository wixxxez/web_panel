<?php 

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
 
class ProfileImageType extends AbstractType
{
    
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder
                ->add('image', FileType::class, [
                    'label' => 'Upload Image',
                    'required' => true,
                    'constraints' =>  
                        new File([
                            'mimeTypes' => [
                                'image/jpeg',
                                'image/png',
                                'image/jpg'
                                // Добавьте сюда другие поддерживаемые типы изображений
                            ],
                            'mimeTypesMessage' => 'Please upload a valid image file',
                        ]),
                        'attr' => [
                            'onchange' => "loadFile(event)",
                            'class' => "block w-full text-sm text-slate-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-violet-50 file:text-violet-700
                            hover:file:bg-violet-100
                          "
                        ]
                     ,
                ]);
        }
    
 
  

    public function configureOptions(OptionsResolver $resolver)
    {
        // $resolver->setDefaults([
        //     // Set your form data class here if needed
        //     'data_class' => 'App\Entity\User',
        // ]);
    }
}