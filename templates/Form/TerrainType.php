<?php

namespace App\Form;

use App\Entity\Terrain;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TerrainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('superficie', NumberType::class, [
                'label' => 'Superficie (en m²)',
            ])
            ->add('localisation', TextType::class, [
                'label' => 'Localisation',
            ])
            ->add('latitude', NumberType::class, [
                'label' => 'Latitude',
            ])
            ->add('longitude', NumberType::class, [
                'label' => 'Longitude',
            ])
            ->add('typeSol', ChoiceType::class, [
                'label' => 'Type de sol',
                'choices' => [
                    'Argileux' => 'argileux',
                    'Sableux' => 'sableux',
                    'Calcaire' => 'calcaire',
                    'Loameux' => 'loameux',
                ],
            ])
            ->add('irrigationDisponible', CheckboxType::class, [
                'label' => 'Irrigation disponible',
            ])
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Disponible' => 'disponible',
                    'Non disponible' => 'non_disponible',
                ],
            ])
            ->add('photo', FileType::class, [
                'label' => 'Photo du terrain (JPEG, PNG, GIF)',
                'mapped' => false, // On gère l'upload manuellement dans le contrôleur
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPEG, PNG ou GIF).',
                    ])
                ],
                'attr' => ['class' => 'form-control'],
            ])




            ->add('save', SubmitType::class, [
                'label' => 'Publier le terrain',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Terrain::class,
        ]);
    }
}
