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
use Symfony\Component\Validator\Constraints\File;

class OutilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de l\'outil',
            'required' => true
            ])
            ->add('URL', UrlType::class, [
                'label' => 'Lien officiel de l\'outil',
            'required' => true
            ])
            ->add('image', FileType::class, [
                'label' => 'Image de l\'article',
                'label_attr' => [
                    'class' => 'mt-3 mb-3',
                ],
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'maxSizeMessage' => 'Le fichier ne doit pas dépasser 1Mo',
                    'mimeTypes' => [
                        'image/jpeg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Uniquement les fichiers JPG et PNG sont autorisés',
                ])
            ],
                'attr' => [
                    'class' => 'form-control-file',
                ],
                'mapped' => false,
                'required' => true,
                'error_bubbling' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description de l\'article',
            'required' => false

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
