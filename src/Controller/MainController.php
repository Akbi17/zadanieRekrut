<?php

namespace App\Controller;

use App\Block\FrontForm;
use App\Entity\Authors;
use App\Block\TopThreeAuthors;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Messages;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main',)]
    public function index(Request $request, EntityManagerInterface $entityManager ,FrontForm $frontForm):Response
    {
        $authors = $entityManager->getRepository(Authors::class)->findAll();
        $message = $frontForm->addArticle($request);

        // Zwróć komunikat do szablonu Twig
        return $this->render('main_api/index.html.twig', [
            'message' => $message,
            'authors' => $authors
        ]);
            
        }
    }
