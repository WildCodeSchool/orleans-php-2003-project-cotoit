<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_ADMIN", message="No access! Get out!")
     * @IsGranted("ROLE_ADMIN", statusCode=404, message="Post not found")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
        ]);
    }
}
