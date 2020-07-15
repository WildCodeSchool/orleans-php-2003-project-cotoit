<?php

namespace App\Controller;

use App\Entity\HourlyRate;
use App\Form\AdminHourlyRateType;
use App\Repository\HourlyRateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tauxHoraire", name="admin_hourlyRate_")
 */
class AdminHourlyRateController extends AbstractController
{
    /**
     * @Route("/{id}/modifier", name="edit", methods={"GET","POST"})
     * @param HourlyRate $hourlyRate
     * @param Request $request
     * @return Response
     */
    public function edit(HourlyRate $hourlyRate, Request $request):Response
    {
        $form = $this->createForm(AdminHourlyRateType::class, $hourlyRate);
        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le taux horaire a bien été modifié.');
            return $this->redirectToRoute('admin');
        }
        return $this->render('admin_hourlyRate/edit.html.twig', [
            'hourlyRate' => $hourlyRate,
            'form' => $form->createView(),
        ]);
    }
}
