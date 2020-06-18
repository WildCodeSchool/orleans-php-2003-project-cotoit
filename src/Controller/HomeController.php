<?php

namespace App\Controller;

use App\Entity\Portfolio;
use App\Form\PortfolioType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Manual;
use Symfony\Component\Serializer\SerializerInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * @param Request $request
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function index(Request $request, SerializerInterface $serializer)
    {
        $manuals = $this->getDoctrine()
            ->getRepository(Manual::class)
            ->findAll();

        $portfolio = new Portfolio();
        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $serializer->decode(file_get_contents($portfolio->getPortfolioFileName()), 'csv');
            $this->addFlash('success', 'Le fichier a bien été envoyé');
            return $this->redirectToRoute('home');
        }

        return $this->render('home/index.html.twig', [
            'manuals' => $manuals,
            'form' => $form->createView(),
        ]);
    }
}
