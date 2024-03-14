<?php

namespace App\Controller;

use App\Entity\Authors;
use App\Block\TopThreeAuthors;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Messages;

class ApiController extends AbstractController
{
    #[Route('/main/api/{id}', name: 'app_main_api', methods:"GET")]
    public function getArticleById(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $message = $entityManager->getRepository(Messages::class)->find($id);

        if (!$message) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $textWithoutHtml = strip_tags($message->getText());
        $article = [
            'id' => $message->getId(),
            'title' => $message->getTitle(),
            'text' => $textWithoutHtml,
            'created_at' => $message->getDate()->format('Y-m-d H:i:s')
        ];
        
        $jsonData = json_encode($article);
        $response = new JsonResponse();
        $response->setContent($jsonData);
        $response->headers->set('Content-Type', 'application/json');

    return $response;
    }

    #[Route('/main/api/{authorName}', name: 'app_main_api', methods:"GET")]
    public function getAllArticlesByAuthor(EntityManagerInterface $entityManager, string $authorName): JsonResponse
    {
        $author = $entityManager->getRepository(Authors::class)->findOneBy(['author' => $authorName]);
    
        if (!$author) {
            throw $this->createNotFoundException(
                'No author found with name '.$authorName
            );
        }
    
        $messages = $author->getMessages();
        $articles = [];
        
        foreach ($messages as $message) {
            $articles[] = [
                'id' => $message->getId(),
                'title' => $message->getTitle(),
                'text' => strip_tags($message->getText()),
                'created_at' => $message->getDate()->format('Y-m-d H:i:s')
            ];
        }
    
        return new JsonResponse($articles);
    }

    #[Route('/main/api/top_authors', name: 'app_main_api', methods:"GET")]
    public function getTopThreeAuthors(TopThreeAuthors $authorService): JsonResponse
    {
        $topAuthors = $authorService->getTopAuthorsLastWeek();
    
        return new JsonResponse($topAuthors);
    }
}
