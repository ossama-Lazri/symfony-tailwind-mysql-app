<?php

// src/Controller/DefaultController.php

namespace App\Controller;
use App\Entity\Task;
use App\Form\Type\TaskType;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    private $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
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
    public function createTask()
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
            
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            return $this->redirectToRoute('task_success');
        }

        return $this->render('add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}