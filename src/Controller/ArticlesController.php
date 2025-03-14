<?php

namespace App\Controller;

use App\Entity\Articles;
use App\Form\ArticlesType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ArticlesController extends AbstractController
{
    #[Route('/articles', name: 'app_articles_index', methods: ['GET', 'POST'])]
    public function index(Request $request, ArticlesRepository $articlesRepository, EntityManagerInterface $entityManager): Response
    {
        // Créer un nouvel article ou récupérer un article existant pour modification
        $articleId = $request->query->get('id');
        $article = $articleId ? $articlesRepository->find($articleId) : new Articles();

        // Créer et gérer le formulaire
        $form = $this->createForm(ArticlesType::class, $article);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', $articleId ? 'Article mis à jour avec succès!' : 'Article ajouté avec succès!');

            // Redirection après ajout ou modification
            return $this->redirectToRoute('app_articles_index');
        }

        // Liste de tous les articles
        $articles = $articlesRepository->findAll();

        // Rendu du template avec les données
        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
            'form' => $form->createView(),
            'articleId' => $articleId,
        ]);
    }

    #[Route('/articles/{id}/delete', name: 'app_articles_delete', methods: ['POST'])]
    public function delete(Request $request, Articles $article, EntityManagerInterface $entityManager): Response
    {
        // Vérification du token CSRF
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
            $this->addFlash('success', 'Article supprimé avec succès!');
        }

        return $this->redirectToRoute('app_articles_index');
    }
}
