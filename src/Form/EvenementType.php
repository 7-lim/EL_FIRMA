<?php

namespace App\Form;

use App\Entity\Administrateur;
use App\Entity\Evenement;
use App\Entity\Fournisseur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\File;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Description',
                    'rows' => 4,
                ],
            ])
            ->add('dateDebut', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('dateFin', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('lieu')
            ->add('image', FileType::class, [
                'label' => 'Image (JPG file)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid JPG image',
                    ])
                ],
            ])
            ->add('nombreDePlaces', IntegerType::class, [
                'attr' => [
                    'placeholder' => 'Nombre de places',
                ],
            ])

            ->add('prix',  NumberType::class, [
                'attr' => [
                    'placeholder' => 'Prix $',
                    'label' => 'Prix $',
                    'scale' => 2,
                ],
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}