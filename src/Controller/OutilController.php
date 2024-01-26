<?php

namespace App\Controller;

use App\Entity\Outil;
use App\Form\SearchType;
use App\Model\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OutilController extends AbstractController
{
    #[Route('/outil/{id}', name: 'outil_detail', requirements:["id" => "\d+"])]
    public function index(
        $id,
        ManagerRegistry $doctrine): Response
    {
        #Etape 1 : Récupérer un outil
        $outil = $doctrine->getRepository(Outil::class)->find($id);

        return $this->render('article/index.html.twig', [
            "outil" => $outil
        ]);
    }
}
