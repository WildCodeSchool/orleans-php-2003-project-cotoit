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
 * @Route("/admin/manuel", name="admin_manual_")
 */
class AdminManualController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @param ManualRepository $manualRepository
     * @return Response
     */
    public function index(ManualRepository $manualRepository): Response
    {

        $manual = $manualRepository->findOneBy([]);
        return $this->render('manual/index.html.twig', [
            'manual' => $manual,
        ]);
    }

    /**
     * @Route("/{id}/modifier", name="edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Manual $manual): Response
    {
        $form = $this->createForm(ManualType::class, $manual);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Le manuel a bien été modifié.'
            );

            return $this->redirectToRoute('admin_manual_index');
        }

        return $this->render('manual/edit.html.twig', [
            'manual' => $manual,
            'form' => $form->createView(),
        ]);
    }
}
