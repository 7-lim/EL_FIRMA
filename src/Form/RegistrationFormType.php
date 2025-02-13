<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class)
            ->add('Prenom', TextType::class)
            ->add('Telephone', TextType::class)
            ->add('email', TextType::class)
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank(['message' => 'Please enter a password']),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('user_type', ChoiceType::class, [
                'choices' => [
                    'Agriculteur' => 'agriculteur',
                    'Fournisseur' => 'fournisseur',
                    'Expert' => 'expert',
                    'Administrateur' => 'administrateur',
                ],
                'mapped' => false,
                'label' => 'Type d\'utilisateur',
                'attr' => ['id' => 'registration_form_user_type'], // Correction de l'ID
            ]);

        // Champs pour Fournisseur
        $builder->add('company_name', TextType::class, [
            'required' => false,
            'attr' => ['class' => 'role-fields', 'id' => 'fournisseur-fields'],
        ])
        ->add('id_fiscale', TextType::class, [
            'required' => false,
            'attr' => ['class' => 'role-fields', 'id' => 'fournisseur-id-fiscale'],
        ])
        ->add('category_product', TextType::class, [
            'required' => false,
            'attr' => ['class' => 'role-fields', 'id' => 'fournisseur-category'],
        ]);

        // Champs pour Expert
        $builder->add('expertise_area', TextType::class, [
            'required' => false,
            'attr' => ['class' => 'role-fields', 'id' => 'expert-fields'],
        ]);

        // Champs pour Agriculteur
        $builder->add('farm_size', NumberType::class, [
            'required' => false,
            'attr' => ['class' => 'role-fields', 'id' => 'agriculteur-fields'],
        ]);

        // Champs pour Administrateur
        $builder->add('admin_code', TextType::class, [
            'required' => false,
            'attr' => ['class' => 'role-fields', 'id' => 'admin-fields'],
        ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
    

}
