<?php
// src/Controller/RegistrationController.php

namespace App\Controller;

use App\Entity\Registration;
use App\Form\RegistrationType;
use App\Repository\RegistrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/registration', name: 'app_registration_')]
class RegistrationController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(RegistrationRepository $repository): Response
    {
        return $this->render('registration/index.html.twig', [
            'registrations' => $repository->findAll(),
        ]);
    }

    #[Route('/add', name: 'add', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $registration = new Registration();
        $form = $this->createForm(RegistrationType::class, $registration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($registration);
            $em->flush();
            $this->addFlash('success', 'Tạo đăng ký thành công!');
            return $this->redirectToRoute('app_registration_index');
        }

        return $this->render('registration/add.html.twig', [
            'registration' => $registration,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'detail', methods: ['GET'])]
    public function detail(Registration $registration): Response
    {
        return $this->render('registration/detail.html.twig', [
            'registration' => $registration,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Registration $registration, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(RegistrationType::class, $registration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Cập nhật thành công!');
            return $this->redirectToRoute('app_registration_index');
        }

        return $this->render('registration/edit.html.twig', [
            'registration' => $registration,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Registration $registration, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $registration->getId(), $request->request->get('_token'))) {
            $em->remove($registration);
            $em->flush();
            $this->addFlash('success', 'Xóa đăng ký thành công!');
        }
        return $this->redirectToRoute('app_registration_index');
    }
}