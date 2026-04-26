<?php

namespace App\Controller;

use App\Entity\Registration;
use App\Repository\RegistrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'registration_list')]
    public function index(RegistrationRepository $repo): Response
    {
        return $this->render('registration/index.html.twig', [
            'registrations' => $repo->findAll(),
        ]);
    }

    #[Route('/registration/delete/{id}', name: 'registration_delete')]
    public function delete(Registration $registration, EntityManagerInterface $em): Response
    {
        $em->remove($registration);
        $em->flush();
        return $this->redirectToRoute('registration_list');
    }
}