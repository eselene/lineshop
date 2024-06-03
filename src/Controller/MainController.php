<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    // Méthode pour afficher les articles avec la possibilité de filtrer selon la catégorie.
    public function index(Request $request, ArticleRepository $articleRepository, CategorieRepository $categorieRepository, SessionInterface $session): Response
    {
        // Récupérer les catégories depuis la base de données
        $articles = $articleRepository->findAll();
        $categoryId = $request->query->get('category');

        if ($categoryId && $categoryId !== "all") {
            // Option de filtre pour afficher selon ce que l'utilisateur choisi.
            $articles = $articleRepository->findByCategorieId($categoryId);
        } else {
            // Toute catégorie ou par défaut
            $articles = $articleRepository->findAll();
        }
        // $user = $session->get('user_id')->getEmail();
        // dd($user);
        // resultat du dd de $user
        // -id: 1
        // -email: "jean@test.fr"
        // -roles: []
        // -password: "$2y$13$bhHG6YFdAjGaemEEdsL6OOt4yV5m./GM3i.oP2gbPCXnkhyvN5BWm"
        // -nom: "jean"
        // -prenom: "jean"
        // -adresse: "123 adresse"
        // -codePostal: "69000"
        // -ville: "Lyon"


        return $this->render('main/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
            'articles' => $articles,
            // 'user' => $user,

        ]);
    }
}
