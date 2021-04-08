<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ArticleRepository $ArticleRepository): Response
    {
    	$article = $ArticleRepository->findAll();

        return $this->render('home/index.html.twig', [
            'article' => $article,
        ]);
    }

    /**
     * @Route("/article/{id}", name="articlePage")
     */
    public function articlePage(Article $article)
    {

        return $this->render('home/article.html.twig', [
            'article' => $article,
        ]);

    }
}
