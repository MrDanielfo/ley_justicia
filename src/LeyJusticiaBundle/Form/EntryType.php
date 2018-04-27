<?php

namespace LeyJusticiaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EntryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                "label" => "Título",
                "required" => "required",
                "attr" => array(
                    "class" => "text",
                    "placeholder" => "Título entrada",
                )    
            ))
            ->add('content', TextareaType::class, array(
                "label" => "Contenido",
                "required" => "required",
                "attr" => array(
                    "class" => "text",
                    "placeholder" => "Contenido de Entrada",
                    "rows" => "15"
                )    
            ))
            ->add('status', ChoiceType::class, array(
                "label" => "Estado",
                "choices" => array(
                   "Público" => "public",
                   "Privado" => "private"
                ),
                "attr" => array(
                    "class" => "text",
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
            ->add('category', EntityType::class, array(
                "label" => "Categorías",
                "class" => 'LeyJusticiaBundle:Category',
                "attr" => array(
                    "class" => "text",
                    "placeholder" => "Categoría",
                )    
            ))
            ->add('tags', TextType::class, array(
                "mapped" => false,
                "label" => "Etiquetas",
                "required" => "required",
                "attr" => array(
                    "class" => "text",
                    "placeholder" => "Etiquetas",
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
            'data_class' => 'LeyJusticiaBundle\Entity\Entry'
        ));
    }
}
