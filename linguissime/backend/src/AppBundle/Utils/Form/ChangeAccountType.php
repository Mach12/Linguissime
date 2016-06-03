<?php

namespace AppBundle\Utils\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ChangeAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class, array('label' => false))
            ->add('username',TextType::class, array('label' => false))
            ->add('name',TextType::class, array('label' => false, 'required' => false))
            ->add('description',TextareaType::class, array('label' => false, 'required' => false))
            ->add('sexe',ChoiceType::class, array(
                    'choices'  => array(
                        'Homme' => 'Homme',
                        'Femme' => 'Femme',
                    ), 'label' => false))
            ->add('residence',TextType::class, array('label' => false, 'required' => false));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User',
        ));
    }
}