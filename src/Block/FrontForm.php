<?php

namespace App\Block;

use App\Entity\Authors;
use App\Entity\Messages;
use App\Trait\TraitForTextCheck;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FrontForm
{
    use TraitForTextCheck;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addArticle(Request $request): string
    {
        $title = $request->request->get('title');
        $content = $request->request->get('content');
        $authorId = $request->request->get('author');

        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $content)) {
            // Zwróć komunikat o błędzie w przypadku niepowodzenia
            return 'Treść może zawierać tylko litery, cyfry i spacje.';
        }

        try {
            $author = $this->entityManager->getRepository(Authors::class)->find($authorId);
            $article = new Messages();
            $article->setTitle($title);
            $article->setText($content);
            $article->addAuthor($author);
            $this->TextCheckAndGet($article);
            $article->setDate(new \DateTime()); // Ustawiamy aktualną datę i czas

            // Zapisz artykuł do bazy danych
            $this->entityManager->persist($article);
            $this->entityManager->flush();
            // Jeśli operacje się powiodą, zwróć komunikat o sukcesie
            return 'Artykuł został dodany poprawnie';
        } catch (\Exception $e) {
            // Przechwyć ewentualne inne wyjątki i zwróć komunikat o błędzie
            return $e->getMessage();
        }
    }
}
