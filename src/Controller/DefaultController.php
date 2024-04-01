<?php

namespace App\Controller;
use App\Entity\Task;
use App\Form\Type\TaskType;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;

class DefaultController extends AbstractController
{

    private $doctrine;
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository, ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->taskRepository = $taskRepository;
    }

    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index(): Response
    {
        $tasks = $this->taskRepository->findAll();
        return $this->render('index.html.twig', [
            'tasks' => $tasks
        ]);
    }

    /**
     * @Route("/task/{id}", name="task_show")
     * @return Response
     */
    public function showTask($id): Response
    {
        $task = $this->taskRepository->find($id);
        return $this->render('show.html.twig', [
            'task' => $task
        ]);
    }

    /**
     * @Route("/home", name="home_page")
     * @return Response
     */
    public function home(): Response
    {
        return $this->render('home.html.twig', []);
    }

    /**
    * @Route("/create/task", name="task_create")
    * @return Response
    */
    public function createTask(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
            
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            // still not create tasks in database (solved)
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/edit/task/{id}", name="task_edit")
    * @return Response
    */
    public function editTask(Task $task, Request $request)
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
            
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            // still not edit tasks in database (solved)
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route("/delete/task/{id}", name="task_delete")
    * @return Response
    */
    public function deleteTask(Task $task)
    {
        $entityManager = $this->doctrine->getManager();
        $entityManager->remove($task);
        $entityManager->flush();

        return $this->redirectToRoute('index');
    }

}