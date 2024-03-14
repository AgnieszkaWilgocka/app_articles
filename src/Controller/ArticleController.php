<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\Type\ArticleFormType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article')]
class ArticleController extends AbstractController
{ 

    #[Route(name:'article_index', methods:'GET|POST')]
    public function index(ArticleRepository $articleRepository) : Response {

        $articles = $articleRepository->findAll();

        return $this->render('article/index.html.twig',
        [
            'articles' => $articles
        ]
        );
    }

    #[Route('/{id}', name:'article_view', requirements:['id' => '[1-9]\d*'], methods:'GET|POST')]
    public function show(Article $article) : Response {

        return $this->render(
            'article/show.html.twig',
            [
            'article' => $article
            ]
            );
    }

    #[Route('/create', name:'create_article', methods:'GET|POST')]
    public function create(Request $request, ArticleRepository $articleRepository, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleFormType::class, $article,
    [
        'action' => $this->generateUrl('create_article')
    ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $articleRepository->save($article);
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('top_authors');
        }

        return $this->render(
            'article/create.html.twig',
            [
                'form' => $form->createView(),
            ]
            );
    }

    #[Route('/{id}/edit', name: 'article_edit', requirements: ['id' => '[1-9]\d*'], methods: 'GET|PUT')]
    public function edit(Article $article, Request $request, ArticleRepository $articleRepository, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleFormType::class, $article,
    [
        'method' => 'PUT',
    ]);
    
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $articleRepository->save($article);
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_index');
        } 

        return $this->render(
            'article/edit.html.twig',
            [
                'form' => $form->createView()
            ]
            );
    }
}
?>