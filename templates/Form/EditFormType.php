<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Entity\Utilisateur;

class EditFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $userType = $options['user_type'];

        // Common fields
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('telephone', TextType::class)
            ->add('email', TextType::class);

        // Add fields based on user type
        switch ($userType) {
            case 'fournisseur':
                $builder
                    ->add('nomEntreprise', TextType::class, [
                        'required' => false,
                        'attr' => ['class' => 'role-fields', 'id' => 'fournisseur-fields'],
                    ])
                    ->add('idFiscale', TextType::class, [
                        'required' => false,
                        'attr' => ['class' => 'role-fields', 'id' => 'fournisseur-id-fiscale'],
                    ])
                    ->add('categorieProduit', TextType::class, [
                        'required' => false,
                        'attr' => ['class' => 'role-fields', 'id' => 'fournisseur-category'],
                    ]);
                break;
            case 'expert':
                $builder->add('domaine_expertise', TextType::class, [
                    'required' => false,
                    'attr' => ['class' => 'role-fields', 'id' => 'expert-fields'],
                ]);
                break;
            case 'agriculteur':
                $builder->add('adresse_exploitation', NumberType::class, [
                    'required' => false,
                    'attr' => ['class' => 'role-fields', 'id' => 'agriculteur-fields'],
                ]);
                break;
            case 'administrateur':
                $builder->add('admin_code', TextType::class, [
                    'required' => false,
                    'attr' => ['class' => 'role-fields', 'id' => 'admin-fields'],
                ]);
                break;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
            'user_type' => null,
            'is_edit' => false,
        ]);
    }
}