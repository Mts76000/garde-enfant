<?php

namespace App\Controller;

use App\Entity\Rdv;
use App\Form\RdvType;
use App\Entity\AddCreche;
use App\Repository\AddCrecheRepository;
use App\Repository\RdvRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/rdv')]
class RdvController extends AbstractController
{
    #[Route('/', name: 'app_rdv_index', methods: ['GET'])]
    public function index(RdvRepository $rdvRepository, AddCrecheRepository $addCrecheRepository): Response
    {
        $user = $this->getUser();
        $validatedRdvs = $rdvRepository->findValidatedRdvs();
        return $this->render('rdv/index.html.twig', [
            'rdvs' => $rdvRepository->findAll(),
            'add_creches' => $addCrecheRepository->findBy(['status' => 'validated']),
            'user' => $user,
            // 'validated_rdvs' => $validatedRdvs,
        ]);
    }

    #[Route('/new-rdv/{id}', name: 'app_rdv_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
        $user = $this->getUser(); // Récupérer l'utilisateur connecté

        $rdv = new Rdv();

        $addCreche = $entityManager->getRepository(AddCreche::class)->find($id);
        $rdv->setPro($addCreche);
        $form = $this->createForm(RdvType::class, $rdv, ['user' => $user]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rdv->setStatus('open');
            $entityManager->persist($rdv);
            $entityManager->flush();

            return $this->redirectToRoute('app_rdv_success', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rdv/new.html.twig', [
            'rdv' => $rdv,
            'form' => $form->createView(),
            'id' => $id,
        ]);
    }

    #[Route('/{id}', name: 'app_rdv_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Rdv $rdv): Response
    {
        return $this->render('rdv/show.html.twig', [
            'rdv' => $rdv,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_rdv_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rdv $rdv, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RdvType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_rdv_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('rdv/edit.html.twig', [
            'rdv' => $rdv,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rdv_delete', methods: ['POST'])]
    public function delete(Request $request, Rdv $rdv, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $rdv->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rdv);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_rdv_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/rdv_succes', name: 'app_rdv_success', methods: ['GET'])]
    public function success(): Response
    {
        return $this->render('rdv/success.html.twig', []);
    }
}
