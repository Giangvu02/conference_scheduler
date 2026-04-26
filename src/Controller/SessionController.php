<?php

namespace App\Controller;

use App\Entity\Session;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'session_list')]
    public function index(SessionRepository $repo): Response
    {
        return $this->render('session/index.html.twig', [
            'sessions' => $repo->findAll(),
        ]);
    }

    #[Route('/session/delete/{id}', name: 'session_delete')]
    public function delete(Session $session, EntityManagerInterface $em): Response
    {
        $em->remove($session);
        $em->flush();
        return $this->redirectToRoute('session_list');
    }
}