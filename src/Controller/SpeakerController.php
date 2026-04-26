<?php

namespace App\Controller;

use App\Entity\Speaker;
use App\Form\SpeakerType;
use App\Repository\SpeakerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/speaker/add', name: 'speaker_add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $speaker = new Speaker();
        $form = $this->createForm(SpeakerType::class, $speaker);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->persist($speaker);
            $em->flush();

            return $this->redirectToRoute('speaker_list');
        }

        return $this->render('speaker/add.html.twig', [
            'form' => $form->createView()
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