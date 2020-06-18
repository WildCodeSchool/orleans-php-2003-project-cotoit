<?php

namespace App\Controller;

use App\Entity\UserActivity;
use App\Form\UserActivityType;
use App\Repository\ActivityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/activity")
 */
class ActivityController extends AbstractController
{
    /**
     * @Route("/", name="activity")
     * @param ActivityRepository $activityRepository
     * @param Request $request
     * @param SessionInterface $session
     * @return Response
     */
    public function customise(ActivityRepository $activityRepository, Request $request, SessionInterface $session)
    : Response
    {
        $userActivity = new UserActivity();
        $userActivity->setActivities($activityRepository->findBy([], ['name' => 'ASC']));

        $form = $this->createForm(UserActivityType::class, $userActivity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $session->set('userActivities', $userActivity);
            $this->addFlash('success', 'Le temps dédié pour chaque activité a bien été enregistré');

            return $this->redirectToRoute('home');
        }

        return $this->render('activity/userActivity.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
