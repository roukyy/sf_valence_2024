<?php

namespace App\Controller\Frontend;

use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('', name: ('app.home'))]
class HomeController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    #[Route('', name: '.app.home', methods: ['GET'])]
    public function index(ArticleRepository $repo): Response
    {
        return $this->render('Frontend/Home/index.html.twig', [
            'articles' => $repo->findLatestArticle(3),
        ]);
    }
}
