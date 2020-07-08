<?php

namespace App\Controller;

use App\Repository\HourlyRateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @param HourlyRateRepository $hourlyRateRepository
     * @return Response
     */
    public function index(HourlyRateRepository $hourlyRateRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'hourlyRate' => $hourlyRateRepository->findOneBy([]),
        ]);
    }
}
