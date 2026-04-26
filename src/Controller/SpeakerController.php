<?php
// src/Controller/SpeakerController.php

namespace App\Controller;

use App\Entity\Speaker;
use App\Form\SpeakerType;
use App\Repository\SpeakerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/speaker', name: 'app_speaker_')]
class SpeakerController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(SpeakerRepository $repository): Response
    {
        return $this->render('speaker/index.html.twig', [
            'speakers' => $repository->findAll(),
        ]);
    }

    #[Route('/add', name: 'add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $speaker = new Speaker();
        $form = $this->createForm(SpeakerType::class, $speaker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Nếu có xử lý upload ảnh (photo), bạn sẽ viết code xử lý ở đây trước khi persist
            $em->persist($speaker);
            $em->flush();
            $this->addFlash('success', 'Thêm diễn giả thành công!');
            return $this->redirectToRoute('app_speaker_index');
        }

        return $this->render('speaker/add.html.twig', [
            'speaker' => $speaker,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'detail', methods: ['GET'])]
    public function detail(Speaker $speaker): Response
    {
        return $this->render('speaker/detail.html.twig', [
            'speaker' => $speaker,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Speaker $speaker, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(SpeakerType::class, $speaker);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Cập nhật thành công!');
            return $this->redirectToRoute('app_speaker_index');
        }

        return $this->render('speaker/edit.html.twig', [
            'speaker' => $speaker,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Speaker $speaker, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $speaker->getId(), $request->request->get('_token'))) {
            $em->remove($speaker);
            $em->flush();
            $this->addFlash('success', 'Xóa thành công!');
        }
        return $this->redirectToRoute('app_speaker_index');
    }
}