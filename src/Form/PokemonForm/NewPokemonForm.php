<?php
namespace App\Form\PokemonForm;

use App\Entity\Location;
use App\Entity\PokemonElement;
use App\Entity\Rarity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use \Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Pokemon;

class NewPokemonForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_pokemon', TextType::class)
            ->add('pokemon_rarity', EntityType::class, [
                'class' => Rarity::class,
            ])
            ->add('hp', IntegerType::class,["label"=>"Point de vie"])
            ->add('atk',IntegerType::class, ["label"=>"Attaque"])
            ->add('def', IntegerType::class,["label"=>"Défence"])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'nom_location',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Région du pokemon'
            ])
            ->add('pokemon_element1', EntityType::class,["class"=>PokemonElement::class,"label"=>"Premier élément du pokémon :"])
            ->add('pokemon_element2', EntityType::class,["class"=>PokemonElement::class,"label"=>"Deuxième élément du pokémon :"])
            ->add('Envoyer',SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pokemon::class,
        ]);
    }
}
