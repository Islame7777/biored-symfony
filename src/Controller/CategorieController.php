<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie_index', methods: ['GET', 'POST'])]
    public function index(Request $request, CategorieRepository $categorieRepository, EntityManagerInterface $entityManager): Response
    {
        // Créer ou récupérer une catégorie existante pour modification
        $categorieId = $request->query->get('id');
        $categorie = $categorieId ? $categorieRepository->find($categorieId) : new Categorie();

        // Créer et gérer le formulaire
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorie);
            $entityManager->flush();

            $this->addFlash('success', $categorieId ? 'Catégorie mise à jour avec succès!' : 'Catégorie ajoutée avec succès!');

            // Redirection après ajout ou modification
            return $this->redirectToRoute('app_categorie_index');
        }

        // Liste de toutes les catégories
        $categories = $categorieRepository->findAll();

        // Rendu du template avec les données
        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
            'form' => $form->createView(),
            'categorieId' => $categorieId,
        ]);
    }

    #[Route('/categorie/{id}/delete', name: 'app_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, Categorie $categorie, EntityManagerInterface $entityManager): Response
    {
        // Vérification du token CSRF
        if ($this->isCsrfTokenValid('delete' . $categorie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categorie);
            $entityManager->flush();
            $this->addFlash('success', 'Catégorie supprimée avec succès!');
        }

        return $this->redirectToRoute('app_categorie_index');
    }
}
