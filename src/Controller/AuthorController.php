<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/author')]
class AuthorController extends AbstractController
{

    #[Route('/topThree', name:'top_authors', methods:"GET|POST")]
    public function TopAuthors(Request $request, AuthorRepository $authorRepository): Response
    {
        $authors = $authorRepository->topThreeAuthors();

        return $this->render(
            'author/topAuthors.html.twig',
            [
                'authors' => $authors
            ]
            );
    }

    #[Route('/{id}', name: 'author_article', requirements:['id' => '[1-9]\d*'], methods:"GET|POST")]
    public function showArticle(Author $author, Request $request, AuthorRepository $authorRepository) : Response {

        return $this->render(
            'author/show.html.twig',
            [
                'author' => $author
            ]
            );
    }
}
?>