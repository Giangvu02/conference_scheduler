<?php
// src/Controller/ConferenceController.php

namespace App\Controller;

use App\Entity\Conference;
use App\Form\ConferenceType;
use App\Repository\ConferenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/conference', name: 'app_conference_')]
class ConferenceController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ConferenceRepository $repository): Response
    {
        return $this->render('conference/index.html.twig', [
            'conferences' => $repository->findAll(),
        ]);
    }

    #[Route('/add', name: 'add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $conference = new Conference();
        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($conference);
            $em->flush();
            $this->addFlash('success', 'Thêm hội nghị thành công!');
            return $this->redirectToRoute('app_conference_index');
        }

        return $this->render('conference/add.html.twig', [
            'conference' => $conference,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'detail', methods: ['GET'])]
    public function detail(Conference $conference): Response
    {
        return $this->render('conference/detail.html.twig', [
            'conference' => $conference,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Conference $conference, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ConferenceType::class, $conference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Cập nhật thành công!');
            return $this->redirectToRoute('app_conference_index');
        }

        return $this->render('conference/edit.html.twig', [
            'conference' => $conference,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Conference $conference, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $conference->getId(), $request->request->get('_token'))) {
            $em->remove($conference);
            $em->flush();
            $this->addFlash('success', 'Xóa thành công!');
        }
        return $this->redirectToRoute('app_conference_index');
    }
}