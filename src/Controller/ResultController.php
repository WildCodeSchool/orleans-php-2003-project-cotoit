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
     * @return Response
     */
    public function index(
        SessionInterface $session
    ) {
        $condos = $session->get('condos');
        dd($condos);

        return $this->render('result/index.html.twig', [
            'controller_name' => 'ResultController',
        ]);
    }
}
