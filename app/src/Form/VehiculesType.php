<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\Users;
use App\Entity\Vehicules;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class)
            ->add('marque',TextType::class)
            ->add('prixJour',NumberType::class)
            ->add('images',FileType::class,[
                'mapped' => false,
            ])
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'name',
            ])

               ->add('disponible', ChoiceType::class, [
                   'label' => 'Disponibilité',
                   'choices' => [
                       'Disponible' => true,
                       'Non disponible' => false,
                   ],
                   'expanded' => true,   // boutons radio
                   'multiple' => false,
               ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicules::class,
        ]);
    }
}
