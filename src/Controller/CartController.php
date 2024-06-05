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
        $tvaRate = 0.20;
        foreach ($cart as $id => $quantity) {
            $article = $articleRepository->find($id);
            if ($article) {
                $price = $article->getPrix() * $quantity;
                $priceWithTva = $article->getPrix() * (1 + $tvaRate) * $quantity;
                $cartWithData[] = [
                    'produit' => $article,
                    'quantite' => $quantity,
                    'prix' => $price,
                    'prixAvecTva' => $priceWithTva,
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
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }

    #[Route('/cart/update/{id}', name: 'cart_update', methods: ['POST'])]
    public function update(SessionInterface $session, Request $request, int $id): Response
    {
        $cart = $session->get('cart', []);
        $quantite = $request->request->get('quantite');

        if ($quantite > 0) {
            $cart[$id] = $quantite;
        } else {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);

        return $this->redirectToRoute('cart_index');
    }
}
