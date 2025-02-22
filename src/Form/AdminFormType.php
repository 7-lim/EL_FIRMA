<?php

namespace App\Form;

use App\Entity\Administrateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdminFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 2, 'max' => 100]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 2, 'max' => 100]),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 6]),
                ],
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 8, 'max' => 15]),
                ],
            ])
            ->add('domaineExpertise', TextType::class, [
                'label' => 'Domaine d\'expertise',
                'required' => false,
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôle',
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'expanded' => false,
                'multiple' => true,
                'mapped' => true,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Créer l\'Administrateur',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Administrateur::class,
        ]);
    }
}
