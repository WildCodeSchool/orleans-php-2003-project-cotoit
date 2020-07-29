<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Service\ParsingManager;
use App\Form\AdminActivityType;
use App\Repository\ActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/activite", name="admin_activity_")
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
     * @Route("/{id}/modifier", name="edit", methods={"GET","POST"})
     * @param Request $request
     * @param Activity $activity
     * @param ParsingManager $parsingManager
     * @return Response
     */
    public function edit(Request $request, Activity $activity, ParsingManager $parsingManager): Response
    {
        $form = $this->createForm(AdminActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activity->setSlug($parsingManager->slug($activity->getName() ?? ''));
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'L\'activité a bien été modifiée.'
            );

            return $this->redirectToRoute('admin_activity_index');
        }

        return $this->render('admin_activity/edit.html.twig', [
            'activity' => $activity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods={"DELETE"})
     * @param Request $request
     * @param Activity $activity
     * @return Response
     */
    public function delete(Request $request, Activity $activity): Response
    {
        if ($this->isCsrfTokenValid('delete' . $activity->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($activity);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'L\'activité a bien été supprimée.'
            );
        }

        return $this->redirectToRoute('admin_activity_index');
    }

    /**
     * @Route("/creer", name="new", methods={"GET","POST"})
     * @param Request $request
     * @param ParsingManager $parsingManager
     * @return Response
     */
    public function new(Request $request, ParsingManager $parsingManager): Response
    {
        $activity = new Activity();
        $form = $this->createForm(AdminActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activity->setSlug($parsingManager->slug($activity->getName() ?? ''));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activity);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'L\'activité a bien été ajoutée.'
            );

            return $this->redirectToRoute('admin_activity_index');
        }

        return $this->render('admin_activity/new.html.twig', [
            'activity' => $activity,
            'form' => $form->createView(),
        ]);
    }
}
