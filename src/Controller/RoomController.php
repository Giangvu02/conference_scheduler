<?php

namespace App\Controller;

use App\Entity\Room;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RoomController extends AbstractController
{
    #[Route('/room', name: 'room_list')]
    public function index(RoomRepository $repo): Response
    {
        return $this->render('room/index.html.twig', [
            'rooms' => $repo->findAll(),
        ]);
    }

    #[Route('/room/delete/{id}', name: 'room_delete')]
    public function delete(Room $room, EntityManagerInterface $em): Response
    {
        $em->remove($room);
        $em->flush();
        return $this->redirectToRoute('room_list');
    }
}