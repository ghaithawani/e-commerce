<?php

namespace App\Form;

use App\Entity\Produits;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProduitsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prix')
            ->add('description')
            ->add('categorie', ChoiceType::class, [
                'choices' => [
                    'Électronique' => 'Électronique',
                    'Mode' => 'Mode',
                    'Maison et Jardin' => 'Maison et Jardin',
                    'Beauté et Soins Personnels' => 'Beauté et Soins Personnels',
                    'Sports et Loisirs' => 'Sports et Loisirs',
                    'Livres et Médias' => 'Livres et Médias',
                    'Alimentation et Boissons' => 'Alimentation et Boissons',
                    'Santé et Bien-être' => 'Santé et Bien-être',
                    'Bébés et Enfants' => 'Bébés et Enfants',
                    'Animaux de compagnie' => 'Animaux de compagnie',
                ],
                'placeholder' => 'Sélectionnez une catégorie',
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateajout')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
