<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use App\Entity\Utilisateur;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Type;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $userType = $options['user_type'];

        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => '⚠️ Le nom est requis pour votre identification']),
                    new Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Le nom doit avoir au moins {{ limit }} caractères',
                        'maxMessage' => 'Le nom ne peut dépasser {{ limit }} caractères'
                        
                        
                    ]),
                ],
            'required' => false,
            ])
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => '⚠️ Le prénom est est requis pour votre identification']),
                    new Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Le prénom doit avoir au moins {{ limit }} caractères',
                        
                        
                    ]),
                ],
                'required' => false,
            ])
            ->add('telephone', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => '📱 Veuillez fournir un numéro de contact valide']),
                    new Regex([
                        'pattern' => '/^\d{8}$/',
                        'message' => 'Le numéro de téléphone doit contenir 8 chiffres',
                        
                    ]),
                ],
                'required' => false,
            ])
            ->add('email', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => '📧 Une adresse email valide est obligatoire']),
                    new Email(['message' => 'Veuillez entrer un email valide']),
                   
                ],
                'required' => false,
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank(['message' => '🔒  créer un mot de passe sécurisé min 6 caracters']),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit avoir au moins {{ limit }} caractères',
                        'max' => 4096,
                        
                    ]),
                    
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

        // Validation spécifique pour chaque rôle
        $builder
            ->add('nomEntreprise', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'Le nom de l\'entreprise ne doit pas dépasser {{ limit }} caractères',
                        
                    ]),
                ],
                
                'attr' => ['class' => 'role-fields', 'id' => 'fournisseur-fields'],
                
            ])
            ->add('idFiscale', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'L\'ID fiscale ne doit pas dépasser {{ limit }} caractères',
                        
                    ]),
                ],
                'attr' => ['class' => 'role-fields', 'id' => 'fournisseur-id-fiscale'],
                
            ])
            ->add('categorieProduit', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'La catégorie de produit ne doit pas dépasser {{ limit }} caractères',
                        
                    ]),
                ],
                'attr' => ['class' => 'role-fields', 'id' => 'fournisseur-category'],
            ])
            ->add('domaine_expertise', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'Le domaine d\'expertise ne doit pas dépasser {{ limit }} caractères',
                        
                    ]),
                ],
                'attr' => ['class' => 'role-fields', 'id' => 'expert-fields'],
            ])
            ->add('adresse_exploitation', NumberType::class, [
                'required' => false,
                'constraints' => [
                    new Type([
                        'type' => 'numeric',
                        'message' => 'L\'adresse d\'exploitation doit être un nombre',
                        
                    ]),
                ],
                'attr' => ['class' => 'role-fields', 'id' => 'agriculteur-fields'],
            ])
            ->add('admin_code', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'max' => 50,
                        'maxMessage' => 'Le code administrateur ne doit pas dépasser {{ limit }} caractères',
                        
                    ]),
                ],
                'attr' => ['class' => 'role-fields', 'id' => 'admin-fields'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
            'user_type' => null, 
            'is_edit' => false, 
        ]);
    }
}
