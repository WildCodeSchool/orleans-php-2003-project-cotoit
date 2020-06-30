<?php

namespace App\Controller;

use App\Entity\Portfolio;
use App\Form\PortfolioType;
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
     * @return Response
     */
    public function index(
        Request $request,
        DecoderInterface $decoder,
        ManualRepository $manualRepository,
        SessionInterface $session
    ) {
        $manual = $manualRepository->findOneBy([]);

        $portfolio = new Portfolio();
        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $decoder->decode(
                ((string)file_get_contents($portfolio->getPortfolioFileName())),
                'csv'
            );

            $session->set('portfolio', $data);

            $this->addFlash('success', 'Le fichier a bien été envoyé');
            return $this->redirectToRoute('activity_user_form');
        }

        return $this->render('home/index.html.twig', [
            'manual' => $manual,
            'form' => $form->createView(),
        ]);
    }
}
