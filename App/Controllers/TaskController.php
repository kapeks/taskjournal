<?php

namespace App\Controllers;

use App\Views\View;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\NotFoundException;
use App\Model\Task;
use App\Middleware\AuthMiddleware;
use App\Services\PaginatorService;
use App\Services\TaskService;

class TaskController
{
    private View $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../Templates/tasks/');
    }

    public function index()
    {
        // Проверяем авторизацию пользователя
        AuthMiddleware::checkAuth();

        // Получаем все задачи текущего пользователя
        $tasks = Task::findByAllUserId($_SESSION['user_id']);

        // Получаем фильтр из запроса (по умолчанию - 'all')
        $filter = $_GET['filter'] ?? 'all';

        // Фильтруем задачи
        if ($filter === 'active') {
            $tasks = array_filter($tasks, fn($task) => $task->completed == 0);
        } elseif ($filter === 'completed') {
            $tasks = array_filter($tasks, fn($task) => $task->completed == 1);
        }

        if ($filter === 'old') {
            $tasks = array_reverse($tasks);
        }

        // Пагинация
        $currentPage = $_GET['page'] ?? 1;
        $perPage = 8;
        $totalItems = count($tasks);

        $paginator = new PaginatorService($totalItems, $perPage, $currentPage);

        // Режем массив задач
        $tasks = array_slice($tasks, $paginator->getOffset(), $perPage);

        // Передаём задачи и ссылки пагинации в представление
        $this->view->render('index.php', [
            'tasks' => $tasks,
            'filter' => $filter,
            'paginator' => $paginator,
            'paginationLinks' => $paginator->getPaginationLinks()
        ]);
    }



    public function create()
    { // интерфейс созданий записи.
        try {
            AuthMiddleware::checkAuth();

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                //проверка csrf_token
                AuthMiddleware::checkCsrfToken($_POST['csrf_token']);

                TaskService::create($_POST, $_SESSION['user_id']);

                header("Location: /tasks");
                exit;
            }
        } catch (InvalidArgumentException $e) {
            $this->view->render('create.php', ['error' => $e->getMessage(), 'formData' => $_POST]);
            return;
        }

        $this->view->render('create.php');
    }

    public function edit($taskID)
    {
        AuthMiddleware::checkAuth();

        $task = Task::find($taskID);
        if ($task->user_id !== $_SESSION['user_id']) {
            throw new NotFoundException();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'PATCH') {

            AuthMiddleware::checkCsrfTokenRedirect($_POST['csrf_token']);

            $formData = [
                'name' => trim($_POST['name'] ?? ''),
                'text' => trim($_POST['text'] ?? ''),
                'task_id' => $taskID,
            ];

            try {
                TaskService::edit($formData, $taskID);

                header("Location: /tasks");
                exit;
            } catch (InvalidArgumentException $e) {
                $this->view->render('edit.php', ['error' => $e->getMessage(), 'formData' => $formData]);
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->view->render('edit.php', ['task' => $task]);
        } else {
            throw new NotFoundException();
        }
    }

    public function destroy()
    {
        AuthMiddleware::checkAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {

            AuthMiddleware::checkCsrfTokenRedirect($_POST['csrf_token']);

            TaskService::destroy($_POST['task_id'], $_SESSION['user_id']);

            header("Location: /tasks");
            exit;
        } else {
            throw new NotFoundException();
        }
    }

    /**
     * подтверждение выполнено ли задание.
     */
    public function completed()
    {
        AuthMiddleware::checkAuth();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'PATCH') {

            AuthMiddleware::checkCsrfTokenRedirect($_POST['csrf_token']);

            TaskService::completed($_POST['task_id'], $_SESSION['user_id']);

            header("Location: /tasks");
            exit;
        } else {
            throw new NotFoundException();
        }
    }
}
