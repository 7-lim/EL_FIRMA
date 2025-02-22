<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => '⚠️ Le nom est requis.']),
                    new Length(['min' => 2, 'max' => 50, 'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères.'])
                ],
                'required' => false,
            ])
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => '⚠️ Le prénom est requis.']),
                    new Length(['min' => 2, 'max' => 50, 'minMessage' => 'Le prénom doit contenir au moins {{ limit }} caractères.'])
                ],
                'required' => false,
            ])
            ->add('telephone', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => '📱 Veuillez fournir un numéro valide.']),
                    new Regex(['pattern' => '/^\d{8}$/', 'message' => 'Le numéro doit contenir 8 chiffres.'])
                ],
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank(['message' => '📧 Une adresse email est obligatoire.']),
                    new Email(['message' => 'Veuillez entrer un email valide.'])
                ],
                'required' => false,
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'constraints' => [
                    new NotBlank(['message' => '🔒 Créez un mot de passe sécurisé (min. 6 caractères).']),
                    new Length(['min' => 6, 'max' => 4096, 'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.'])
                ],
                'required' => false,
            ]);

        if (!$options['is_edit']) {
            $builder->add('user_type', ChoiceType::class, [
                'choices' => [
                    'Agriculteur' => 'agriculteur',
                    'Fournisseur' => 'fournisseur',
                    'Expert' => 'expert',
                    'Administrateur' => 'administrateur',
                ],
                'mapped' => false,
                'label' => 'Type d\'utilisateur',
            ]);
        }

        // Dynamic fields for each role
        $builder
            // Fields for Fournisseur
            ->add('nomEntreprise', TextType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Length(['max' => 100, 'maxMessage' => 'Le nom de l\'entreprise ne doit pas dépasser {{ limit }} caractères.'])
                ],
                'attr' => ['class' => 'role-fields', 'id' => 'fournisseur-fields'],
            ])
            ->add('idFiscale', TextType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Length(['max' => 50, 'maxMessage' => 'L\'ID fiscale ne doit pas dépasser {{ limit }} caractères.'])
                ],
                'attr' => ['class' => 'role-fields', 'id' => 'fournisseur-id-fiscale'],
            ])
            ->add('categorieProduit', TextType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Length(['max' => 100, 'maxMessage' => 'La catégorie de produit ne doit pas dépasser {{ limit }} caractères.'])
                ],
                'attr' => ['class' => 'role-fields', 'id' => 'fournisseur-category'],
            ])
            // Fields for Expert
            ->add('domaineExpertise', TextType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Length(['max' => 100, 'maxMessage' => 'Le domaine d\'expertise ne doit pas dépasser {{ limit }} caractères.'])
                ],
                'attr' => ['class' => 'role-fields', 'id' => 'expert-fields'],
            ])
            // Fields for Agriculteur
            ->add('adresseExploitation', TextType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Length(['max' => 255, 'maxMessage' => 'L\'adresse d\'exploitation ne doit pas dépasser {{ limit }} caractères.'])
                ],
                'attr' => ['class' => 'role-fields', 'id' => 'agriculteur-fields'],
            ])
            // Fields for Administrateur
            ->add('adminCode', TextType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Length(['max' => 50, 'maxMessage' => 'Le code administrateur ne doit pas dépasser {{ limit }} caractères.'])
                ],
                'attr' => ['class' => 'role-fields', 'id' => 'admin-fields'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class, // ✅ Corrected to match entity
            'user_type' => null,
            'is_edit' => false,
        ]);
    }
}
