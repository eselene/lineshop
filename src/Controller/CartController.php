<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ArticleRepository;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'cart_index')]
    public function index(SessionInterface $session, ArticleRepository $articleRepository): Response
    {
        $cart = $session->get('cart', []);
        $cartWithData = [];

        foreach ($cart as $id => $quantity) {
            $article = $articleRepository->find($id);
            if ($article) {
                $price = $article->getPrix();
                $prixQuantite = $price * $quantity;
                $cartWithData[] = [
                    'produit' => $article,
                    'quantite' => $quantity,
                    'prix' => $price,
                    'prixQuantite' => $prixQuantite
                ];
            }
        }

        return $this->render('cart/index.html.twig', [
            'cart' => $cartWithData,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(SessionInterface $session, int $id): Response
    {
        $cart = $session->get('cart', []);

        if (!isset($cart[$id])) {
            $cart[$id] = 0;
        }

        $cart[$id]++;
        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove(SessionInterface $session, int $id): Response
    {
        $cart = $session->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/cart/update/{id}', name: 'cart_update', methods: ['POST'])]
    public function update(SessionInterface $session, Request $request, int $id): Response
    {
        $cart = $session->get('cart', []);
        $quantite = (int)$request->request->get('quantite', 0);
        $prix = (float)$request->request->get('prix', 0);
        
        if ($quantite > 0) {
            $cart[$id] = $quantite;
        } else {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }
}
