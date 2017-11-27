<?php

namespace Members\Bundle\ManagementBundle\Form\Type;
use Members\Bundle\ManagementBundle\Form\ProfilePhotoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ProfileFormType extends AbstractType
{
    private $class;

    /**
     * @param string $class The User class name
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('latitude', 'hidden', array('label' => false))
            ->add('longitude','hidden', array('label' => false))
            ->add('username', 'text', array('label' =>  false))
            ->add('email', 'email', array('label' =>  "Email"))
            ->add('domain_name','text', array('label' => "Domain Name"))
            ->add('store_description','textarea', array('label' => "Store Description"))
            //->add('profile_picture','file', array('label' => false, 'attr'=>array('class'=>'chooser'), 'required' => true, 'data_class' => 'Members\Bundle\ManagementBundle\Entity\ProfilePhoto'))
        ;
        
        $builder->add('current_password', 'password', array(
            'label' => 'form.current_password',
            'translation_domain' => 'FOSUserBundle',
            'mapped' => false, 
            'constraints' => new UserPassword(),
        ));
    }

    public function getParent()
    {
        return 'fos_user_profile';
    }



    public function getName()
    {
        return 'members_management_user_profile';
    }

    
}
