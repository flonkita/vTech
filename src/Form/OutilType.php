<?php

namespace App\Form;

use App\Entity\Outil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OutilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' =>'Nom de l\'outil'
            ])
            ->add('URL', UrlType::class)
            ->add('image')
            ->add('description', TextareaType::class, [
                'label' => 'Description de l\'article',
                
            ])
            ->add('PublishedAt')
            ->add('ModifiedAt')
            ->add('statut')
            ->add('Tags')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Outil::class,
        ]);
    }
}
