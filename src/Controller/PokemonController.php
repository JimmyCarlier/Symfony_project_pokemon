<?php

namespace App\Controller;

use App\Entity\Pokemon;
use App\Entity\User;
use App\Form\PokemonForm\NewPokemonForm;
use App\Form\PokemonForm\UpdatePokemonForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PokemonController extends AbstractController
{
    #[Route('/addPokemon', name: 'add_pokemon')]
    public function createPokemon(EntityManagerInterface $entityManagerInterface, Request $request): Response
    {
        $pokemon = new Pokemon();
        $form = $this->createForm(NewPokemonForm::class, $pokemon);
        $form->handleRequest($request);

        $currentUser = $this->getUser();
        $user = $entityManagerInterface->getRepository(User::class)->findOneBy(['username' => $currentUser->getUsername()]);

        if ($form->isSubmitted() && $form->isValid()) {
            $pokemon->setUser($user);
            $entityManagerInterface->persist($pokemon);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('pokemon_list', ["username" => $user->getUsername()]);
        }

        return $this->render('pokemon/allPokemon.html.twig', [
            'form' => $form,
            'showFormCreate' => true,
            'pokemons' => $user->getPokemon(),
            'name' => $user->getUsername(),
            'user' => $user
        ]);

    }

    #[Route('/pokemon/{id}', name: 'app_pokemon')]
    public function index(int $id, EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Pokemon::class);
        $pokemon = $repository->find($id);
        $currentUser = $this->getUser();
        $user = $entityManager->getRepository(User::class)->findOneBy(['username'=>$currentUser->getUsername()]);

        if (!$pokemon) {
            return new Response("Pokemon doesn't exist");
        }

        return $this->render('pokemon/index.html.twig', [
            'controller_name' => 'PokemonController',
            'pokemon' => $pokemon,
            'user'=>$user
        ]);
    }

    #[Route("/pokemonList/{username}", name: 'pokemon_list')]
    public function pokeList(String $username,EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        $currentUser = $this->getUser();
        $user = $entityManager->getRepository(User::class)->findOneBy(['username'=>$username]);

        if($currentUser && $currentUser->getUserIdentifier() === $user->getUserIdentifier()){

            return $this->render('pokemon/allPokemon.html.twig',[
                'pokemons' => $user->getPokemon(),
                'user' => $user,
                'name' => $user->getUsername(),
                'showFormCreate' => false
            ]);
        } else {
            throw new AccessDeniedException("This content is not allowed");
        }
    }

    #[Route('/delete/{id}', name: 'delete_pokemon')]
    public function deletePokemon(Pokemon $pokemon, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        $user = $this->getUser();
        if($user && $user === $pokemon->getUser()){

            $entityManager->remove($pokemon);
            $entityManager->flush();

            return $this->redirectToRoute('pokemon_list');

        } else {
            throw new AccessDeniedException("This content is not allowed");
        }
    }

    #[Route('/update/{id}', name: 'update_pokemon')]
    public function updatePokemon(Pokemon $pokemon, Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        $currentUser = $this->getUser();
        $user = $entityManager->getRepository(User::class)->findOneBy(["username"=>$currentUser->getUsername()]);

        if($user && $user === $pokemon->getUser()){
            $form = $this->createForm(UpdatePokemonForm::class, $pokemon);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $user = $this->getUser();
                $entityManager->flush();

                return $this->redirectToRoute('pokemon_list',['username'=>$user->getUsername()]);
            }

            return $this->render('pokemon/updatePokemon.html.twig', [
                'form' => $form->createView(),
                'pokemon' => $pokemon,
            ]);

        } else {
            throw new AccessDeniedException("This content is not allowed");
        }
    }
}
