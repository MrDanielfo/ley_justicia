<?php

namespace LeyJusticiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
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
                    "placeholder" => "Nombre Completo",
                )    
            ))
            ->add('email', EmailType::class, array(
                "label" => "Email",
                "required" => "required",
                "attr" => array(
                    "class" => "text",
                    "placeholder" => "E-mail",
                )    
            ))
            ->add('password', PasswordType::class, array(
                "label" => "Password",
                "required" => "required",
                "attr" => array(
                    "class" => "text",
                    "placeholder" => "Password",
                )    
            ))
            ->add('image', FileType::class, array(
                "label" => "Imagen",
                "attr" => array(
                    "class" => "text"
                ),
                "data_class" => null,
                "required" => false
            ))
            ->add('biography', TextareaType::class, array(
                "label" => "Biografía",
                "required" => "required",
                "attr" => array(
                    "class" => "text",
                    "placeholder" => "Escribe tu biografía",
                    "rows" => "15"
                ),
                "required" => false
            ))
            ->add('Registrarse', SubmitType::class, array(
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
            'data_class' => 'LeyJusticiaBundle\Entity\User'
        ));
    }
}
