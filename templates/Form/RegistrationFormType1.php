<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // These fields ARE mapped to the Utilisateur entity properties
            ->add('nom', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
            ])
            ->add('nomEntreprise', TextType::class, [
                'label' => 'Nom de l\'entreprise',
                'required' => false,
            ])
            ->add('idFiscale', TextType::class, [
                'label' => 'ID Fiscale',
                'required' => false,
            ])
            ->add('categorieProduit', TextType::class, [
                'label' => 'Catégorie de produit',
                'required' => false,
            ])

            // FIELDS NOT MAPPED to the entity
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false,
            ])
            ->add('user_type', ChoiceType::class, [
                'label' => 'Type d\'utilisateur',
                'choices' => [
                    'Agriculteur' => 'agriculteur',
                    'Fournisseur' => 'fournisseur',
                ],
                'mapped' => false,  // <--- important (no matching entity property)
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // The mapped fields above (nom, prenom, telephone, email, etc.)
        // match properties on App\Entity\Utilisateur
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
