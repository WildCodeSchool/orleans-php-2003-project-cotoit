<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CalculatingManager;
use Dompdf\Dompdf;
use Dompdf\Options;

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
        $profitCondo = $calculatingManager->profitabilityCondo($condos);

        arsort($profitCondo, SORT_NUMERIC);
        $topTenCondos = array_slice($profitCondo, 0, 10, true);
        $nonProfitableCondos = array_filter($profitCondo, function ($fee) {
            return $fee <= 0;
        });

        return $this->render('result/index.html.twig', [
            'profit' => $profit,
            'profitCondo' => $profitCondo,
            'topTenCondos' => $topTenCondos,
            'nonProfitableCondos' => $nonProfitableCondos,
        ]);
    }

    /**
     * @Route("/pdf", name="pdf")
     */
    public function resultpdf()
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('result/pdfResult.html.twig', [
            'title' => "Welcome to our PDF Test"
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream();
    }
}
