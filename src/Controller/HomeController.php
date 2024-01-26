<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Model\SearchData;
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
    public function index(OutilRepository $outilRepository, TagRepository $tagRepository, PaginatorInterface $paginator, Request $request
    ): Response {
        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $searchData->page = $request->query->getInt('page', 1);
            $outil = $outilRepository->findBySearch($searchData);

            return $this->render('templates/home/index.html.twig', [
                'form' => $form->createView(),
                'outil' => $outil->findPublished($request->query->getInt('page', 1))
            ]);
        }

        // 'outils' => $outilRepository->findBy([
        //         'statut' => 'publie'
        //     ])

        $pagination = $paginator->paginate(
            $outilRepository->paginationQuery(),
            $request->query->get('page', 1),
            1 // limite d'outils à afficher pour passer à la page suivante
        );
        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'pagination' => $pagination,
            'tag' => $tagRepository->findAll(),
        ]);
    }
}
