<?php
// src/Controller/SessionController.php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/session', name: 'app_session_')]
class SessionController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(SessionRepository $repository): Response
    {
        return $this->render('session/index.html.twig', [
            'sessions' => $repository->findAll(),
        ]);
    }

    #[Route('/add', name: 'add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $session = new Session();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($session);
            $em->flush();
            $this->addFlash('success', 'Thêm phiên họp thành công!');
            return $this->redirectToRoute('app_session_index');
        }

        return $this->render('session/add.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'detail', methods: ['GET'])]
    public function detail(Session $session): Response
    {
        return $this->render('session/detail.html.twig', [
            'session' => $session,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Session $session, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Cập nhật thành công!');
            return $this->redirectToRoute('app_session_index');
        }

        return $this->render('session/edit.html.twig', [
            'session' => $session,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Session $session, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $session->getId(), $request->request->get('_token'))) {
            $em->remove($session);
            $em->flush();
            $this->addFlash('success', 'Xóa thành công!');
        }
        return $this->redirectToRoute('app_session_index');
    }
}