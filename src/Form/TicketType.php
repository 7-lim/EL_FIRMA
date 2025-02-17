<?php

namespace App\Form;

use App\Entity\Agriculteur;
use App\Entity\Evenement;
use App\Entity\Expert;
use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Prix')
            // ->add('agriculteur', EntityType::class, [
            //     'class' => Agriculteur::class,
            //     'choice_label' => 'id',
            // ])
            // ->add('expert', EntityType::class, [
            //     'class' => Expert::class,
            //     'choice_label' => 'id',
            // ])
            ->add('evenement', EntityType::class, [
                'class' => Evenement::class,
                'choice_label' => 'titre',
                'placeholder' => 'Choisir un événement',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
