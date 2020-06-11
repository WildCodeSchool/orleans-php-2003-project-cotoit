<?php

namespace App\Controller;

use App\Form\PortfolioType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Manual;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $manuals = $this->getDoctrine()
            ->getRepository(Manual::class)
            ->findAll();

        $form = $this->createForm(PortfolioType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('home');
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'manuals' => $manuals,
            'form' => $form->createView(),
        ]);
    }
}
