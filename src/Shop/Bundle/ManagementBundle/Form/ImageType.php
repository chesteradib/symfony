<?php

namespace Shop\Bundle\ManagementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


use Symfony\Component\Form\Extension\Core\Type\FileType;

class ImageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('file', FileType::class, array('label' => false,
            'attr'=>array('class'=>'chooser'),
           // 'required' => false
            ))

        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function ConfigureOptions(OptionsResolver$resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\Bundle\ManagementBundle\Entity\Image'
        ));
    }

    /**
     * @return string
     */
    
    public function getBlockPrefix()
    {
        return 'shop_bundle_managementbundle_image';
    }
}
