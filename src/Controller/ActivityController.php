<?php

namespace App\Controller;

use App\Entity\HousingActivity;
use App\Entity\UserActivity;
use App\Form\HousingActivityType;
use App\Repository\ActivityRepository;
use App\Service\ParsingManager;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/activity", name="activity_")
 */
class ActivityController extends AbstractController
{
    /**
     * @Route("/", name="user_form")
     * @param ActivityRepository $activityRepository
     * @param Request $request
     * @param SessionInterface $session
     * @param ValidatorInterface $validator
     * @param ParsingManager $parsingManager
     * @return Response
     */
    public function customise(
        ActivityRepository $activityRepository,
        Request $request,
        SessionInterface $session,
        ValidatorInterface $validator,
        ParsingManager $parsingManager
    ): Response {
        $activities = $activityRepository->findBy([], ['name' => 'ASC']);

        $housingActivity = new HousingActivity();
        foreach ($activities as $activity) {
            $userActivity = new UserActivity();
            $userActivity->setActivity($activity->getName());
            $userActivity->setHour($activity->getHour());
            $userActivity->setMinute($activity->getMinute());

            $housingActivity->addActivity($userActivity);
        }

        $form = $this->createForm(HousingActivityType::class, $housingActivity);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $housingActivities = $housingActivity->getActivities()->toArray();

            $errors = new ConstraintViolationList();
            foreach ($housingActivities as $userActivity) {
                $errors = $validator->validate($userActivity);
            }

            if (count($errors) > 0) {
                return $this->render('activity/_validation.html.twig', [
                    'errors' => $errors,
                ]);
            }

            $housingActivities = $parsingManager->slugArrayKey($parsingManager->activityToKey($housingActivities));

            $session->set('housingActivities', $housingActivities);
            $this->addFlash('success', 'Le temps dédié pour chaque activité a bien été enregistré');


            return $this->redirectToRoute('home');
        }

        return $this->render('activity/userActivity.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
