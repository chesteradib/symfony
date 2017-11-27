<?php

namespace Shop\Bundle\ManagementBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Shop\Bundle\ManagementBundle\Form\ImageType;

class PostType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('postTitle', TextType::class, array('required' => false))
            ->add('postContent', TextareaType::class, array('required' => false))
            ->add('postNotes', TextareaType::class, array('required' => false))
            ->add('postPrice', NumberType::class, array('required' => false))
            ->add('images', CollectionType::class, array(
                'entry_type' => ImageType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false
                ) )
            ->add('categories');
            
        
    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shop\Bundle\ManagementBundle\Entity\Post'
            
        ));
    }
    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'shop_bundle_managementbundle_posttype';
    }

}
