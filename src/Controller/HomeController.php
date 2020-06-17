<?php

namespace App\Controller;

use App\Form\PortfolioType;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Manual;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

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
            $portfolioFile = $form->get('portfolioFileName')->getData();
//            if ($portfolioFile) {
//                var_dump($portfolioFile);
//            }
            return $this->redirectToRoute('home');
        }

        return $this->render('home/index.html.twig', [
            'manuals' => $manuals,
            'form' => $form->createView(),
        ]);
    }
}
