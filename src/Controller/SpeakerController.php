<?php

namespace App\Controller;

use App\Entity\Speaker;
use App\Repository\SpeakerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpeakerController extends AbstractController
{
    #[Route('/speaker', name: 'speaker_list')]
    public function index(SpeakerRepository $repo): Response
    {
        return $this->render('speaker/index.html.twig', [
            'speakers' => $repo->findAll(),
        ]);
    }

    #[Route('/speaker/delete/{id}', name: 'speaker_delete')]
    public function delete(Speaker $speaker, EntityManagerInterface $em): Response
    {
        $em->remove($speaker);
        $em->flush();
        return $this->redirectToRoute('speaker_list');
    }
}