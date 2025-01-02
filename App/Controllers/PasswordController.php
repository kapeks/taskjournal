<?php

namespace App\Controllers;

use App\Model\User;
use App\Views\View;
use App\Services\MailService;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\NotFoundException;
use App\Services\PasswordService;
use App\Middleware\AuthMiddleware;

/**
 * контроллер отвечает за пароль пользователя.
 */
class PasswordController
{
    private View $view;

    public function __construct()
    {
        $this->view = new View(__DIR__ . '/../Templates/users/password/');
    }

    /**
     * отправка кода восстановления.
     */
    public function resetRequest()
    {
        if (!empty($_POST['email'])) {
            try {

                AuthMiddleware::checkCsrfToken($_POST['csrf_token']);

                $user = PasswordService::passwordReset($_POST);

                $_SESSION['password_reset_expires_at'] = time() + 300; // устанавливаем время жизни кода 5 минут.

                MailService::sendResetPassword($user->email, $user->password_reset_code);
            } catch (InvalidArgumentException $e) {
                $this->view->render('reset_request.php', ['error' => $e->getMessage(), 'formData' => $_POST]);
                return;
            }

            if ($user instanceof User) {
                $this->view->render('verify_code.php');
                return;
            }
        }
        $this->view->render('reset_request.php');
    }

    /**
     * проверка кода.
     */
    public function verifyCode()
    {
        if (!empty($_POST['code'])) {
            try {

                AuthMiddleware::checkCsrfToken($_POST['csrf_token']);

                if (strlen((string)$_POST['code']) !== 6) {
                    throw new InvalidArgumentException('Код должен состоять из 6 символов');
                }
                if (time() > $_SESSION['password_reset_expires_at']) //перенаправляем,если код недействительный.
                {
                    unset($_SESSION['password_reset_expires_at']);
                    setcookie('invalid_code', 'true', time() + 5, '/');
                    header("Location: /password/reset");
                    exit;
                }

                $user = User::findOneByColumn('password_reset_code', $_POST['code']);

                if ($user === null) {
                    throw new InvalidArgumentException('неправильный код');
                }

                // Сохраняем ID пользователя в сессии
                $_SESSION['password_reset_user_id'] = $user['id'];

                $this->view->render('change_password.php');
            } catch (InvalidArgumentException $e) {
                $this->view->render('verify_code.php', ['error' => $e->getMessage()]);
            }
        } else {
            throw new NotFoundException();
        }
    }

    /**
     * смена пароля.
     */
    public function changePassword()
    {
        if (!empty($_POST['password'])) {
            try {

                if (empty($_SESSION['password_reset_user_id'])) {
                    throw new InvalidArgumentException('Ошибка сессии, попробуйте снова.');
                }

                AuthMiddleware::checkCsrfToken($_POST['csrf_token']);

                $user = User::find($_SESSION['password_reset_user_id']);
                PasswordService::passwordRecover($_POST, $user);

                setcookie('password_success', 'true', time() + 300, '/');
                header("Location: /users/login");
                exit;
            } catch (InvalidArgumentException $e) {
                $this->view->render('change_password.php', ['error' => $e->getMessage()]);
                return;
            }
        } else {
            throw new NotFoundException();
        }
    }
}
