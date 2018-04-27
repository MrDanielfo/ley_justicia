<?php

namespace LeyJusticiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 

class CategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                "label" => "Nombre",
                "required" => "required",
                "attr" => array(
                    "class" => "text",
                    "placeholder" => "Nombre Categoría",
                )    
            ))
            ->add('description', TextareaType::class, array(
                "label" => "Descripción",
                "required" => "required",
                "attr" => array(
                    "class" => "text",
                    "placeholder" => "Descripción",
                )    
            ))
            ->add('Guardar', SubmitType::class, array(
                "attr" => array(
                    "type" => "submit",
                    "class" => "button"     
                )    
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LeyJusticiaBundle\Entity\Category'
        ));
    }
}
