<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/tag', name: 'admin_tag_')]
class TagController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(TagRepository $tagRepository): Response
    {
        return $this->render('admin/tag/index.html.twig', [
            'tag' => $tagRepository->findAll(),
        ]);
    }

    #[Route('/new', name : 'new')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        #Etape 1 : Créer un objet vide
        $tag = new Tag;

        #Etape 2 : Créer le formulaire
        $formTag = $this->createForm(TagType::class,$tag);

        $formTag->handleRequest($request);
        if ($formTag->isSubmitted() && $formTag->isValid()) {
            $data = $formTag->getData();

            #Etape 3 : On appel l'entity manager de doctrine
            $entityManager = $doctrine->getManager();

            #Etape 4 : on indique a doctrine que l'on souhaite préparer l'enregistrement d'un nouvel élément
            $entityManager->persist($data);

            #Etape 5: on valide a doctrine que l'on veut enregisterer/persister en BDD
            $entityManager->flush();

            #Etape 6: on affiche ou on redirge vers une autre page
            return $this->redirectToRoute('admin_tag_index');
        }
        #Etape 7 : On envoie le formulaire dans la vue
        return $this->render('admin/tag/new.html.twig', [
            'formTag' => $formTag->createView()
        ]);
    }

    #[Route('{id}/edit', name: 'edit', methods: ["GET", "POST"])]
    public function edit(Request $request, Tag $tag, TagRepository $tagRepository, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $formTag = $this->createForm(TagType::class, $tag);
        $formTag->handleRequest($request);

        if ($formTag->isSubmitted() && $formTag->isValid()) {
            $data = $formTag->getData();
            $entityManager->persist($data);
            $entityManager->flush();
            // $tagRepository->add($tag, true);
            return $this->redirectToRoute('admin_tag_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/tag/edit.html.twig', [
            'tag' => $tag,
            'formTag' => $formTag,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete')]
    public function delete($id, Tag $tag, ManagerRegistry $doctrine): Response
    {
        #Etape 1 : On appelle l'entity manager de doctrine
        $entityManager = $doctrine->getManager();

        #Etape 2 : On récupère (grâce au repository de doctrine) l'objet que l'on souhaite modifier
        $tag = $doctrine->getRepository(Tag::class)->find($id);

        #Etape 3 : On supprime à l'aide de l'entity manager 
        $entityManager->remove($tag);

        #Etape 4 : On valide les modifications
        $entityManager->flush();

        return $this->redirectToRoute('admin_tag_index', [], Response::HTTP_SEE_OTHER);
    }
}