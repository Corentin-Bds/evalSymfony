<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GeneralController extends AbstractController
{
    
    #[Route('/', name: 'app_general')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $derniersProduits = $entityManager->getRepository(Produit::class)->findBy([], ['id' => 'DESC'], 5);

        return $this->render('general/index.html.twig', [
            'derniersProduits' => $derniersProduits,
        ]);
    }

    #[Route('/produit/{id}', name: 'afficher_produit')]
    public function afficherProduit(EntityManagerInterface $entityManager, Request $request, Produit $produit): Response
    {
        $commentaire = new Commentaire();
        $commentaireForm = $this->createForm(CommentaireType::class, $commentaire);

        $commentaireForm->handleRequest($request);

        if ($commentaireForm->isSubmitted() && $commentaireForm->isValid()) {
            $commentaire->setProduitCommentaire($produit);

            $entityManager->persist($commentaire);
            $entityManager->flush();

            // Rediriger ou effectuer d'autres actions après l'enregistrement du commentaire
        }

        return $this->render('general/afficher-produits.html.twig', [
            'produit' => $produit,
            'commentaireForm' => $commentaireForm->createView(),
        ]);
    }

    #[Route('/liste-produits', name: 'liste_produits')]
    public function liste(EntityManagerInterface $entityManager): Response
    {
        $toutProduits = $entityManager->getRepository(Produit::class)->findAll();

        return $this->render('general/liste-produits.html.twig', [
            'liste_produits' => $toutProduits,
        ]);
    }

}
