<?php

namespace App\Controller;

use App\Repository\ConferenceRepository;
use App\Repository\SpeakerRepository;
use App\Repository\RoomRepository;
use App\Repository\SessionRepository;
use App\Repository\RegistrationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        ConferenceRepository $conferenceRepo,
        SpeakerRepository $speakerRepo,
        RoomRepository $roomRepo,
        SessionRepository $sessionRepo,
        RegistrationRepository $registrationRepo,
        UserRepository $userRepo
    ): Response
    {
        // Tổng số dữ liệu
        $totalConferences = count($conferenceRepo->findAll());
        $totalSpeakers = count($speakerRepo->findAll());
        $totalRooms = count($roomRepo->findAll());
        $totalSessions = count($sessionRepo->findAll());
        $totalRegistrations = count($registrationRepo->findAll());
        $totalUsers = count($userRepo->findAll());

        // Dữ liệu gần đây
        $recentConferences = $conferenceRepo->findBy([], ['id' => 'DESC'], 5);
        $recentSessions = $sessionRepo->findBy([], ['id' => 'DESC'], 5);
        $recentSpeakers = $speakerRepo->findBy([], ['id' => 'DESC'], 5);

        // Thống kê trạng thái đăng ký
        $registrations = $registrationRepo->findAll();
        $registrationStats = [];
        foreach ($registrations as $registration) {
            $status = $registration->getStatus() ?? 'Unknown';
            $registrationStats[$status] = ($registrationStats[$status] ?? 0) + 1;
        }

        return $this->render('home/index.html.twig', [
            'totalConferences' => $totalConferences,
            'totalSpeakers' => $totalSpeakers,
            'totalRooms' => $totalRooms,
            'totalSessions' => $totalSessions,
            'totalRegistrations' => $totalRegistrations,
            'totalUsers' => $totalUsers,
            'recentConferences' => $recentConferences,
            'recentSessions' => $recentSessions,
            'recentSpeakers' => $recentSpeakers,
            'registrationStats' => $registrationStats,
        ]);
    }
}