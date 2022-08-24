<?php

namespace App\Controller;

use App\Entity\Pomodoros;
use App\Form\PomodorosType;
use App\Repository\PomodorosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\Translation\t;

#[Route('/pomodoros')]
class PomodorosController extends AbstractController
{
    #[Route('/', name: 'app_pomodoros_index', methods: ['GET'])]
    public function index(PomodorosRepository $pomodorosRepository): Response
    {
        return $this->render('pomodoros/index.html.twig', [
            'pomodoros' => $pomodorosRepository->findAll(),
            'lastPomodoro' => $pomodorosRepository->getLastPomodoro(),
        ]);
    }

    #[Route('/new', name: 'app_pomodoros_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PomodorosRepository $pomodorosRepository): Response
    {

        $pomodoro = new Pomodoros();
        // set default values
        $pomodoro->setCreationDate(new \DateTime());
        $pomodoro->setDuration(25);
        $pomodoro->setShortBreak(5);
        $pomodoro->setLongBreak(15);

        $form = $this->createForm(PomodorosType::class, $pomodoro, [
            'action' => $this->generateUrl('app_pomodoros_new'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pomodorosRepository->add($pomodoro, true);

            return $this->redirectToRoute('app_pomodoros_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pomodoros/new.html.twig', [
            'pomodoro' => $pomodoro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pomodoros_show', methods: ['GET'])]
    public function show(Pomodoros $pomodoro): Response
    {
        return $this->render('pomodoros/show.html.twig', [
            'pomodoro' => $pomodoro,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pomodoros_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pomodoros $pomodoro, PomodorosRepository $pomodorosRepository): Response
    {
        $form = $this->createForm(PomodorosType::class, $pomodoro, [
            'action' => $this->generateUrl('app_pomodoros_edit', ['id' => $pomodoro->getId()]),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pomodorosRepository->add($pomodoro, true);

            return $this->redirectToRoute('app_pomodoros_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('pomodoros/edit.html.twig', [
            'pomodoro' => $pomodoro,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pomodoros_delete', methods: ['POST'])]
    public function delete(Request $request, Pomodoros $pomodoro, PomodorosRepository $pomodorosRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pomodoro->getId(), $request->request->get('_token'))) {
            $pomodorosRepository->remove($pomodoro, true);
        }

        return $this->redirectToRoute('app_pomodoros_index', [], Response::HTTP_SEE_OTHER);
    }

    public function timer(PomodorosRepository $pomodorosRepository): Response
    {
        return $this->render('timer.html.twig', [
            'pomodoro' => $pomodorosRepository->getLastPomodoro()
        ]);
    }
}
