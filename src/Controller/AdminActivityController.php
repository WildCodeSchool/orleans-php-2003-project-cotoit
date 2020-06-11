<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Form\ActivityType;
use App\Repository\ActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/activity", name="admin_activity_")
 */
class AdminActivityController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET"})
     * @param ActivityRepository $activityRepository
     * @return Response
     */
    public function index(ActivityRepository $activityRepository): Response
    {
        return $this->render('admin_activity/index.html.twig', [
            'activities' => $activityRepository->findBy([], ['name' => 'ASC']),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Activity $activity
     * @return Response
     */
    public function edit(Request $request, Activity $activity): Response
    {
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_activity_index');
        }

        return $this->render('admin_activity/edit.html.twig', [
            'activity' => $activity,
            'form' => $form->createView(),
        ]);
    }
}
