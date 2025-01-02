<?php

namespace App\Controllers;

use App\Views\View;
use App\Model\User;
use App\Model\Task;
use App\Exceptions\InvalidArgumentException;
use App\Services\MailService;
use App\Middleware\AuthMiddleware;
use App\Services\UserService;

class UserController
{
    private View $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../Templates/users/');
    }

    public function profile()
    {
        AuthMiddleware::checkAuth();
        $user = User::find($_SESSION['user_id']);
        $task = Task::findByAllUserId($user->id);
        $this->view->render('profile.php', ['user' => $user, 'task' => $task]);
    }


    public function login()
    {
        if (!empty($_POST)) {
            try {
                //проверка csrf_token
                AuthMiddleware::checkCsrfToken($_POST['csrf_token']);

                //запоминаем данные пользователя, если он это выберет.
                if (!empty($_POST['remember_me'])) {
                    // Устанавливаем куки на 30 дней
                    setcookie('user_email', $_POST['email'], time() + (30 * 24 * 60 * 60));
                    setcookie('rememberMe', 'true', time() + (30 * 24 * 60 * 60));
                } else {
                    // Удаляем куки, если пользователь отказался
                    setcookie('user_email', '', time() - 3600);
                    setcookie('rememberMe', '', time() - 3600);
                }

                $user = UserService::login($_POST);

                session_regenerate_id(true);

                $_SESSION['user_id'] = $user['id'];

                header("Location: /tasks");
                exit;
            } catch (InvalidArgumentException $e) {
                $this->view->render('login.php', ['error' => $e->getMessage(), 'formData' => $_POST]);
                return;
            }
        }

        $this->view->render('login.php');
    }

    public function logout()
    {
        AuthMiddleware::checkAuth();

        session_unset();
        session_destroy();

        header("Location: /");
        exit;
    }

    public function register()
    {
        if (!empty($_POST)) {
            try {
                //проверка csrf_token
                AuthMiddleware::checkCsrfToken($_POST['csrf_token']);

                $user = UserService::register($_POST);

                //отправляем письмо для активации.
                MailService::sendVerificationEmail($user->email, $user->verification_token);

                // генерируем новый CSRF токен.
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            } catch (InvalidArgumentException $e) {
                $this->view->render('register.php', [
                    'error' => $e->getMessage(),
                    'formData' => $_POST
                ]);
                return;
            }
            if ($user instanceof User) {
                $this->view->render('send_mail/success_register.php');
                return;
            }
        }

        $this->view->render('register.php');
    }

    /**
     * активация пользователя по email.
     * 
     * @param string $activateCode токен активации.
     */
    public function verifyEmail(string $activateCode)
    {
        try {
            UserService::activate($activateCode);
            setcookie('activation_success', 'true', time() + 5, '/');
            header("Location: /users/login");
            exit;
        } catch (InvalidArgumentException $e) {
            $this->view->render('exeption_activation.php', ['error' => $e->getMessage()]);
        }
    }

    public function delete()
    {
        AuthMiddleware::checkAuth();

        try {
            if (!empty($_POST))
            {
                AuthMiddleware::checkCsrfToken($_POST['csrf_token']);

                UserService::delete($_POST, $_SESSION['user_id']);

                session_unset();
                session_destroy();
                
                setcookie('success_delete', 'true', time() + 5, '/');
                header("Location: /users/login");
                exit;
            }
        } catch (InvalidArgumentException $e)
        {
            $this->view->render('user_deletion_confirmation.php', ['error' => $e->getMessage()]);
            return;
        }

        $this->view->render('user_deletion_confirmation.php');
    }
}
