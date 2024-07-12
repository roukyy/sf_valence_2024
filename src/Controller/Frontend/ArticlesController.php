<?php

namespace App\Controller\Frontend;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/articles', name: 'app.articles')]
class ArticlesController extends AbstractController
{
    #[Route('', name: '.index', methods: ['GET'])]

    public function index(ArticleRepository $repo): Response
    {
        return $this->render('Frontend/ListArticles/index.html.twig', [
            'articles' => $repo->displayArticles(),
        ]);
    }

    #[Route('/{id}', name: '.details', methods: ['GET'])]
    public function details(?Article $article): Response
    {
        if(!$article || !$article->isEnable()){
            $this->addFlash('error', 'Article non trouvé');

            return $this->redirectToRoute('app.articles.index');
        }
        return $this->render('Frontend/DisplayArticle/index.html.twig', [
            'article' => $article,
        ]);
    }

}



