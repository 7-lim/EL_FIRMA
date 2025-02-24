<?php
// src/Form/AdminFormType.php

namespace App\Form;

use App\Entity\Administrateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
         $builder
             ->add('nom', TextType::class, [
                  'label' => 'Nom',
             ])
             ->add('prenom', TextType::class, [
                  'label' => 'Prénom',
             ])
             ->add('email', EmailType::class, [
                  'label' => 'Email',
             ])
             ->add('telephone', TextType::class, [
                  'label' => 'Téléphone',
             ])
             ->add('plainPassword', PasswordType::class, [
                  'label'    => 'Mot de passe',
                  'mapped'   => false,
             ]);
    }
    
    public function configureOptions(OptionsResolver $resolver): void
    {
         $resolver->setDefaults([
              'data_class' => Administrateur::class,
         ]);
    }
}
