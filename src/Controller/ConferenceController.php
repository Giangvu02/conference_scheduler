<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Repository\ConferenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    #[Route('/conference', name: 'conference_list')]
    public function index(ConferenceRepository $repo): Response
    {
        return $this->render('conference/index.html.twig', [
            'conferences' => $repo->findAll(),
        ]);
    }

    #[Route('/conference/delete/{id}', name: 'conference_delete')]
    public function delete(Conference $conference, EntityManagerInterface $em): Response
    {
        $em->remove($conference);
        $em->flush();
        return $this->redirectToRoute('conference_list');
    }
}