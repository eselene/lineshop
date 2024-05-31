<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main', methods: ['GET'])]
    // Methode pour récuperer les articles, avec option de filtre selon la catégorie
    public function index(Request $request, ArticleRepository $articleRepository, CategorieRepository $categorieRepository): Response
    {
        $categoryId = $request->query->get('category');
        // option de filtre selon la catégorie
        if ($categoryId && $categoryId !== 'all') {
            //l'utilisateur a choisi un filtre
            $articles = $articleRepository->findByCategorieId($categoryId);
        } else {
            //l'utilisateur a choisi un filtre toutes les catégories ou la valeur par défaut
            $articles = $articleRepository->findAll();
        }

        return $this->render('main/index.html.twig', [
            'articles' => $articles,
            'categories' => $categorieRepository->findAll()
        ]);
    }
}
