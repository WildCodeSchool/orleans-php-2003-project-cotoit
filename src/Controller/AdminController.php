<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_ADMIN", statusCode=404)
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
        ]);
    }
}
