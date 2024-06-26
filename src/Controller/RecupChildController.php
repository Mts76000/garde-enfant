<?php

namespace App\Controller;

use App\Entity\RecupChild;
use App\Form\RecupChildType;
use App\Repository\RecupChildRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/recup/child')]
class RecupChildController extends AbstractController
{
    #[Route('/', name: 'app_recup_child_index', methods: ['GET'])]
    public function index(RecupChildRepository $recupChildRepository): Response
    {

        $user = $this->getUser();
        $tuteur = $user->getUser();

        return $this->render('recup_child/index.html.twig', [
            // 'recup_children' => $recupChildRepository->findAll(),
            'recup_children' => $tuteur,
            'user' => $user,
        ]);
    }

    #[Route('/new', name: 'app_recup_child_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $recupChild = new RecupChild();
        $form = $this->createForm(RecupChildType::class, $recupChild);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {

            $user = $this->getUser();
            $recupChild->setUser($user);

            $entityManager->persist($recupChild);
            $entityManager->flush();



           return $this->redirectToRoute('app_recup_child_success');
        }

        return $this->render('recup_child/new.html.twig', [
            'recup_child' => $recupChild,
            'form' => $form,
            'user' => $user,
        ]);
    }

    // #[Route('/{id}', name: 'app_recup_child_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    // public function show(RecupChild $recupChild): Response
    // {
    //     return $this->render('recup_child/show.html.twig', [
    //         'recup_child' => $recupChild,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'app_recup_child_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RecupChild $recupChild, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RecupChildType::class, $recupChild);
        $form->handleRequest($request);
        $user = $this->getUser();
        //dd($form);
        if ($form->isSubmitted() && $form->isValid()) {
            


            $entityManager->flush();

            return $this->redirectToRoute('app_recup_child_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('recup_child/edit.html.twig', [
            'recup_child' => $recupChild,
            'form' => $form,
            'user' => $user,
        ]);
    }

    #[Route('/{id}', name: 'app_recup_child_delete', methods: ['POST'])]
    public function delete(Request $request, RecupChild $recupChild, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recupChild->getId(), $request->request->get('_token'))) {
            $entityManager->remove($recupChild);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_recup_child_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}/sup', name: 'app_recup_child_sup', methods: ['GET'])]
    public function sup(Request $request, RecupChild $recupChild, EntityManagerInterface $entityManager): Response
    {
        $recupChild->setStatus('delete');
        $entityManager->flush();

        return $this->redirectToRoute('app_recup_child_index', [], Response::HTTP_SEE_OTHER);
        return $this->render('full_child/sup.html.twig', []);
    }


    #[Route('/success', name: 'app_recup_child_success', methods: ['GET'])]
    public function success(): Response
    {
        $user = $this->getUser();
        return $this->render('recup_child/success.html.twig', [
            'user' => $user,
        ]);
    }
}
