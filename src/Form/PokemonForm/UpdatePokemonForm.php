<?php

namespace App\Form\PokemonForm;

use App\Entity\Location;
use App\Entity\Pokemon;
use App\Entity\PokemonElement;
use App\Entity\Rarity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdatePokemonForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_pokemon', TextType::class)
            ->add('hp', IntegerType::class)
            ->add('atk', IntegerType::class)
            ->add('def', IntegerType::class)
            ->add('pokemon_rarity', EntityType::class, [
                'class' => Rarity::class,
                'choice_label' => 'rarity_name',
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'nom_location',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('pokemon_element1',EntityType::class,[
                'class'=>PokemonElement::class,
                'choice_label'=>'nom_element',
            ])
            ->add('pokemon_element2',EntityType::class,[
                'class'=>PokemonElement::class,
                'choice_label'=>'nom_element',
            ])
            ->add('Valider', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pokemon::class,
        ]);
    }
}
