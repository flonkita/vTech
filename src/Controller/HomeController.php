<?php

namespace App\Controller;

use App\Repository\OutilRepository;
use App\Repository\TagRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(OutilRepository $outilRepository, TagRepository $tagRepository, PaginatorInterface $paginator, Request $request): Response
    {


        // 'outils' => $outilRepository->findBy([
        //         'statut' => 'publie'
        //     ])

        $pagination = $paginator->paginate(
            $outilRepository->paginationQuery(),
            $request->query->get('page', 1),
            5
        );
        return $this->render('home/index.html.twig', [
            'pagination' => $pagination,
            'tag' => $tagRepository->findAll(),
        ]);
    }   
}
