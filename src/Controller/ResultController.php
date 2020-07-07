<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CalculatingManager;

/**
 * @Route("/result", name="result_")
 */
class ResultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param SessionInterface $session
     * @param CalculatingManager $calculatingManager
     * @return Response
     */
    public function index(
        SessionInterface $session,
        CalculatingManager $calculatingManager
    ) {
        $condos = $session->get('condos');
        $profit = $calculatingManager->profitLot($condos);

        return $this->render('result/index.html.twig', [
            'profit' => $profit,
            'condos' => $condos,
        ]);
    }
}
