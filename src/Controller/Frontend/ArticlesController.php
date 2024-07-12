<?php

namespace App\Controller\Frontend;

use App\Entity\Article;
use App\Filter\ArticleFilter;
use App\Form\ArticleFilterType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/articles', name: 'app.articles')]
class ArticlesController extends AbstractController
{
    #[Route('', name: '.index', methods: ['GET'])]

    public function index(ArticleRepository $repo, Request $request): Response
    {
        $articleFilter = new ArticleFilter;

        $form = $this->createForm(ArticleFilterType::class, $articleFilter);
        $form->handleRequest($request);

        $articles = $repo->findFilterArticle($articleFilter);

        return $this->render('Frontend/ListArticles/index.html.twig', [
            'articles' => $articles,
            'form' => $form,
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



