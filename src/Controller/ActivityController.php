<?php

namespace App\Controller;

use App\Entity\HousingActivity;
use App\Entity\UserActivity;
use App\Form\HousingActivityType;
use App\Repository\ActivityRepository;
use App\Service\ParsingManager;
use App\Service\ValidatingManager;
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
     * @param ValidatingManager $validatingManager
     * @param ParsingManager $parsingManager
     * @return Response
     */
    public function customise(
        ActivityRepository $activityRepository,
        Request $request,
        SessionInterface $session,
        ValidatingManager $validatingManager,
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

            $errorMessages = $validatingManager->validationLoop($housingActivities);

            if (!empty($errorMessages)) {
                return $this->render('activity/userActivity.html.twig', [
                    'form' => $form->createView(),
                    'errors' => $errorMessages,
                ]);
            }

            $housingActivities = $parsingManager->slugArrayKey($parsingManager->activityToKey($housingActivities));
            $session->set('housingActivities', $housingActivities);

            $session->set(
                'condos',
                $parsingManager->mergeActivitiesIntoHousing(
                    $session->get('userHousing'),
                    $session->get('housingActivities')
                )
            );

            $this->addFlash('success', 'Le temps dédié pour chaque activité a bien été enregistré');

            return $this->redirectToRoute('result_index');
        }

        return $this->render('activity/userActivity.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
