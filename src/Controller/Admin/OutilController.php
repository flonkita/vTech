<?php

namespace App\Controller\Admin;

use App\Entity\Outil;
use App\Form\OutilType;
use App\Repository\OutilRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/outil', name: 'admin_outil_')]
class OutilController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(OutilRepository $outilRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'outils' => $outilRepository->findAll(),
        ]);
    }

    #[Route('/new', name:'new', methods:["GET", "POST"])]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
    #Etape 1 : Créer un objet vide
    $outil = new Outil;

    #Etape 2 : Créer le formulaire
    $formOutil = $this->createForm(OutilType::class,$outil);

    $formOutil->handleRequest($request);
        if ($formOutil->isSubmitted() && $formOutil->isValid()) {
            $data = $formOutil->getData();

            if ($formOutil->get('image')->getData() == null) {
                $image = null;
            } else {
                $image = $formOutil->get('image')->getData()->getClientOriginalName();
            }
            if ($image) {
                $image = $formOutil->get('image')->getData()->getClientOriginalName();
                $data->setImage($image);
                $formOutil->get('image')->getData()->move(
                    $this->getParameter('images_directory'),
                    $image
                );
            }
            #Etape 3 : On appel l'entity manager de doctrine
            $entityManager = $doctrine->getManager();

            #Etape 4 : on indique a doctrine que l'on souhaite préparer l'enregistrement d'un nouvel élément
            $entityManager->persist($data);

            #Etape 5: on valide a doctrine que l'on veut enregisterer/persister en BDD
            $entityManager->flush();

            #Etape 6: on affiche ou on redirge vers une autre page
            return $this->redirectToRoute('admin_outil_index');
        }
        #Etape 7 : On envoie le formulaire dans la vue
        return $this->render('admin/outil/new.html.twig', [
            'formOutil' => $formOutil->createView()
        ]);
    }
}