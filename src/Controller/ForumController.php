<?php

namespace App\Controller;

use App\Entity\Forum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    #[Route('/forum',name:'app_forum')]
    public function showAllForum(EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        $entityForum = $entityManager->getRepository(Forum::class)->findAll();
        return $this->render('forum/forum.html.twig',[
            'forums'=> $entityForum,
            'user'=>$this->getUser(),
            'showForm'=>false,
        ]);
    }

    #[Route('/forum/addForum', name:'app_addForum')]
    public function addForum(EntityManagerInterface $entityManager, Request $request): Response{

        $entityForum = $entityManager->getRepository(Forum::class)->findAll();
        $forum = new Forum();
        $formForum = $this->createFormBuilder($forum)
            ->add('titre_forum', TextType::class)
            ->add('forum_context', TextType::class)
            ->add('Envoyer',SubmitType::class)
            ->getForm();

        $formForum->handleRequest($request);
        if ($formForum->isSubmitted() && $formForum->isValid()) {
            $forum->setUser($this->getUser());
            $entityManager->persist($forum);
            $entityManager->flush();

            return $this->redirectToRoute('app_forum',[
                'forums'=> $entityForum,
                'user'=>$this->getUser(),
                'showForm'=>false,
            ]);
        }

        return $this->render('forum/forum.html.twig', [
            'user' => $this->getUser(),
            'forums'=> $entityForum,
            'formForum' => $formForum,
            'showForm'=> true
        ]);
    }

   #[Route('/forum/{id}',name:'app_specificForum')]
   public function showThisForum(Forum $forum): \Symfony\Component\HttpFoundation\Response
    {

        return $this->render('forum/forum_comm.html.twig',[
            'user'=>$this->getUser(),
            'forum'=>$forum,
            'commentaires'=>$forum->getCommentaires()
        ]);
    }
}
