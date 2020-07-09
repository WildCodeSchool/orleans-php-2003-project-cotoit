<?php

namespace App\Controller;

use App\Service\ColumnManager;
use App\Service\PopulatingManager;
use App\Entity\Portfolio;
use App\Form\PortfolioType;
use App\Service\ValidatingManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Manual;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use App\Repository\ManualRepository;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * @param Request $request
     * @param DecoderInterface $decoder
     * @param ManualRepository $manualRepository
     * @param SessionInterface $session
     * @param ValidatingManager $validatingManager
     * @param PopulatingManager $populatingManager
     * @param ColumnManager $columnManager
     * @return Response
     */
    public function index(
        Request $request,
        DecoderInterface $decoder,
        ManualRepository $manualRepository,
        SessionInterface $session,
        ValidatingManager $validatingManager,
        PopulatingManager $populatingManager,
        ColumnManager $columnManager
    ) {
        $manual = $manualRepository->findOneBy([]);

        $portfolio = new Portfolio();
        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $session->set('portfolio', $decoder->decode(
                ((string)file_get_contents($portfolio->getPortfolioFileName())),
                'csv'
            ));

            $errors = $columnManager->sameColumn($session->get('portfolio'));
            if (empty($errors)) {
                $session->set('userHousing', $populatingManager->populateHousing($session->get('portfolio')));
                $errors = $validatingManager->validationLoopForPortfolio($session->get('userHousing'));
            }
            if (!empty($errors)) {
                return $this->render('home/index.html.twig', [
                    'form' => $form->createView(),
                    'manual' => $manual,
                    'errors' => $errors,
                ]);
            }

            $this->addFlash('success', 'Le fichier a bien été envoyé');
            return $this->redirectToRoute('activity_user_form');
        }
        return $this->render('home/index.html.twig', [
            'manual' => $manual,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/template", name="template")
     * @param ColumnManager $columnManager
     */
    public function template(ColumnManager $columnManager)
    {
        $template = $columnManager->getTemplateCsv();
        $response = new Response($template);
        $response->headers->set('Content-Type', 'text/csv');

        return $response;
    }
}
