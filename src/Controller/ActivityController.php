<?php

namespace App\Controller;

use App\Form\UserActivityType;
use App\Repository\ActivityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/activity")
 */
class ActivityController extends AbstractController
{
    /**
     * @Route("/")
     * @param ActivityRepository $activityRepository
     * @param Request $request
     * @return Response
     */
    public function customise(ActivityRepository $activityRepository, Request $request): Response
    {
        $activities = $activityRepository->findBy([], ['name' => 'ASC']);
        $form = $this->createForm(UserActivityType::class, ['activities' => $activities]);
        $form->handleRequest($request);

        return $this->render('activity/_customise_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
