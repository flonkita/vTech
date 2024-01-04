<?php

namespace App\Controller\Admin;

use App\Repository\OutilRepository;
use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin', name: 'admin_')]
class IndexController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(TagRepository $tagRepository,OutilRepository $outilRepository): Response
    {

        $outil = $outilRepository->findAll();
        $tag = $tagRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'outil' => $outil,
            'tag' => $tag,
        ]);
    }
}
