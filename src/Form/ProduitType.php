<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('NomProduit', TextType::class)
            ->add('description', TextareaType::class)
            /*->add('image', FileType::class, ['required' => false])*/
            ->add('quantite', IntegerType::class)
            
            
            ->add('prix', NumberType::class, [
                'label' => 'Prix (€)',
                'attr' => [
                    'class' => 'form-control border-success',
                    'placeholder' => 'Prix en Euro',
                    'step' => '0.01' // Allows decimal inputs like 12.99
                ],
                'scale' => 2, // Ensures two decimal places
                'empty_data' => '0', // Prevents null errors
                'html5' => true, // Enables HTML5 number input
            ])
            
            /*->add('prix', FloatType::class)*/
            /*->add('fournisseur', ChoiceType::class, [
                'choices' => [
                    'Fournisseur 1' => 'fournisseur1',
                    'Fournisseur 2' => 'fournisseur2',
                ],
            ])*/
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'name', // Display category name
                'placeholder' => 'Choose a category',
            ]);

            
                

            /*->add('categorie', ChoiceType::class, [
                'choices' => [
                    'Catégorie 1' => 'categorie1',
                    'Catégorie 2' => 'categorie2',
            ],
            ])*/

        /*$builder->get('image')->addModelTransformer(new FileToStringTransformer());*/
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}

