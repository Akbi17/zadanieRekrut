<?php

namespace App\Block;

use App\Entity\Messages;
use Doctrine\ORM\EntityManagerInterface;

class TopThreeAuthors
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getTopAuthorsLastWeek(): array
{
    $now = new \DateTime();
    $weekAgo = new \DateTime();
    $weekAgo->sub(new \DateInterval('P1W'));

    $messages = $this->entityManager->getRepository(Messages::class)
        ->createQueryBuilder('m')
        ->where('m.date BETWEEN :weekAgo AND :now')
        ->setParameter('weekAgo', $weekAgo)
        ->setParameter('now', $now)
        ->getQuery()
        ->getResult();

    
    $authorMessagesCount = [];

    foreach ($messages as $message) {
        foreach ($message->getAuthors() as $author) {
            $authorName = $author->getAuthor();

            if (!isset($authorMessagesCount[$authorName])) {
                $authorMessagesCount[$authorName] = 1;
            } else {
                $authorMessagesCount[$authorName]++;
            }
        }
    }

    arsort($authorMessagesCount);

    return array_slice($authorMessagesCount, 0, 3);
}

}
