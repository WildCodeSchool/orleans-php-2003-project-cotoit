<?php

namespace App\Controller;

use App\Entity\Manual;
use App\Form\ManualType;
use App\Repository\ManualRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/manual")
 */
class ManualController extends AbstractController
{
    /**
     * @Route("/", name="manual_index", methods={"GET"})
     */
    public function index(ManualRepository $manualRepository): Response
    {

        $manual = $manualRepository->findOneBy([]);
        return $this->render('manual/index.html.twig', [
            'manual' => $manual,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="manual_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Manual $manual): Response
    {
        $form = $this->createForm(ManualType::class, $manual);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('manual_index');
        }

        return $this->render('manual/edit.html.twig', [
            'manual' => $manual,
            'form' => $form->createView(),
        ]);
    }
}
