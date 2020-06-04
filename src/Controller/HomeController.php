<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Manual;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        $manuals = $this->getDoctrine()
            ->getRepository(Manual::class)
            ->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'manuals' => $manuals,
        ]);
    }
}
