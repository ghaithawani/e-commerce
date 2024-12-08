<?php

namespace App\Form;

use App\Entity\Reclamation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //requireds are set to false pour mettre en valeur le controle de saisie
            ->add('name', TextType::class, [
                'label' => 'Name',
                'required' => false,
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Last Name',
                'required' => false,
            ])
            ->add('descrirec', TextType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            // ->add('daterec', DateType::class, [
            //     'widget' => 'single_text',
            //     'label' => 'Date of Reclamation',
            //     // This is not required if you want to allow nullable dates
            //     'required' => false,
            // ])
            ->add('categorierec', TextType::class, [
                'label' => 'Category',
                'required' => false,
            ]);
            // ->add('statutrec', ChoiceType::class, [
            //     'label' => 'Status',
            //     'choices' => [
            //         'Non traitée' => 'non traitee',
            //         'Traitée' => 'traitee',
            //     ],
            //     'placeholder' => 'Choose an option',
            // ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
