<?php

namespace App\Controller;

use App\Repository\OutilRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(OutilRepository $outilRepository, TagRepository $tagRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'outils' => $outilRepository->findAll(),
            'tag' => $tagRepository->findAll(),
        ]);
    }   
}
