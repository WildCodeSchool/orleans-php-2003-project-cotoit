<?php

namespace App\Controller;

use App\Service\ParsingManager;
use Exception;
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
     * @param ParsingManager $parsingManager
     * @return Response
     * @throws Exception
     */
    public function index(
        SessionInterface $session,
        CalculatingManager $calculatingManager,
        ParsingManager $parsingManager
    ) {
        $condos = $session->get('condos');

        if (empty($session->get('condos'))) {
            throw new Exception('Fichier vide. Merci de charger un fichier depuis la page d\'accueil.');
        } else {
            $numberCondos = count($condos);

            $totalRevenue = $calculatingManager->revenue($condos);
            $totalCost = $calculatingManager->globalCost($condos);
            $totalProfit = $calculatingManager->profit($totalRevenue, $totalCost);

            $profit = $calculatingManager->profitLot($condos);
            $profitability = $calculatingManager->profitability($condos);
            $profitCondo = $calculatingManager->profitabilityCondo($condos);
            $profitCondo = $parsingManager->sortProfitCondo($profitCondo);

            $topTenCondos = $calculatingManager->topTen($profitCondo);

            $nonProfitableCondos = array_filter($profitCondo, function ($fee) {
                return $fee['profit'] <= 0;
            });

            $activitiesCost = $calculatingManager->globalPercentageCostActivities($condos);

            $deficitHousings = $calculatingManager->getHousingFromName($condos, array_keys($nonProfitableCondos));
            $nonProfitableCondos = $calculatingManager->percentageLossActivity($deficitHousings, $nonProfitableCondos);


            $session->set('profit', $profit);
            $session->set('profitCondo', $profitCondo);
            $session->set('topTenCondos', $topTenCondos);
            $session->set('nonProfitableCondos', $nonProfitableCondos);
            $session->set('totalRevenue', $totalRevenue);
            $session->set('totalProfit', $totalProfit);
            $session->set('profitability', $profitability);
            $session->set('numberCondos', $numberCondos);
            $session->set('activitiesCost', $activitiesCost['activities']);

            return $this->render('result/index.html.twig');
        }
    }


    /**
     * @Route("/pdfResult", name="pdfResult")
     */
    public function exportResultToPDF()
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('result/pdfResult.html.twig');

        $dompdf->setPaper('A4', 'portrait');

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream();
    }
}
