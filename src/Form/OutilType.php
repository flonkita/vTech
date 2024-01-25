<?php

namespace App\Form;

use App\Entity\Outil;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                'label' => 'Nom de l\'outil'
            ])
            ->add('URL', UrlType::class, [
                'label' => 'Lien officiel de l\'outil'
            ])
            ->add('image', FileType::class, [
                'label' => 'Image de l\'article',
                'label_attr' => [
                    'class' => 'mt-3 mb-3',
                ],
                'attr' => [
                    'class' => 'form-control-file',
                ],
                'mapped' => false,
                'required' => false,
                'error_bubbling' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description de l\'article',

            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => function (Tag $tag): string {
                    return $tag->getNom();
                },
                'multiple' => true,

            ])
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'Publié' => 'publie',
                    'Brouillon' => 'brouillon',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary mt-3',
                ],
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Outil::class,
        ]);
    }
}
