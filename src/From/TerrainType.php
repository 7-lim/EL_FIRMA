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
