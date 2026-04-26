<?php
// src/Controller/RoomController.php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/room', name: 'app_room_')]
class RoomController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(RoomRepository $repository): Response
    {
        return $this->render('room/index.html.twig', [
            'rooms' => $repository->findAll(),
        ]);
    }

    #[Route('/add', name: 'add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $room = new Room();
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($room);
            $em->flush();
            $this->addFlash('success', 'Thêm phòng thành công!');
            return $this->redirectToRoute('app_room_index');
        }

        return $this->render('room/add.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'detail', methods: ['GET'])]
    public function detail(Room $room): Response
    {
        return $this->render('room/detail.html.twig', [
            'room' => $room,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Room $room, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Cập nhật thành công!');
            return $this->redirectToRoute('app_room_index');
        }

        return $this->render('room/edit.html.twig', [
            'room' => $room,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Room $room, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $room->getId(), $request->request->get('_token'))) {
            $em->remove($room);
            $em->flush();
            $this->addFlash('success', 'Xóa thành công!');
        }
        return $this->redirectToRoute('app_room_index');
    }
}