<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Terrain;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DateDebut', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de début',
                'html5' => true,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Sélectionnez la date de début'],
            ])
            ->add('DateFin', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de fin',
                'html5' => true,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Sélectionnez la date de fin'],
            ])
            ->add('PrixLocation', MoneyType::class, [
                'currency' => 'EUR',
                'label' => 'Prix de location (€)',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Saisissez le prix de location'],
            ])
            ->add('PaiementEffectue', CheckboxType::class, [
                'label' => 'Paiement effectué ?',
                'required' => false,
                'attr' => ['class' => 'form-check-input'],
            ])
            ->add('ModePaiement', ChoiceType::class, [
                'label' => 'Mode de paiement',
                'choices' => [
                    'Espèces' => 'cash',
                    'Carte bancaire' => 'credit_card',
                    'Virement bancaire' => 'bank_transfer',
                ],
                'attr' => ['class' => 'form-control'],
            ])
            ->add('Statut', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'En attente' => 'pending',
                    'Confirmé' => 'confirmed',
                    'Annulé' => 'canceled',
                ],
                'attr' => ['class' => 'form-control'],
            ])

            
            ->add('terrain', EntityType::class, [
                'class' => Terrain::class,
                'choice_label' => 'localisation',  // Change to a descriptive field (e.g., "localisation")
                'label' => 'Terrain associé',
                'attr' => ['class' => 'form-control'],
                'placeholder' => 'Sélectionnez un terrain',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
