<?php

namespace App\Middleware;
use App\Exceptions\InvalidArgumentException;

/**
 * класс отвечает за проверку сессий.
 */
class AuthMiddleware
{
    /**
     * Проверяет, авторизован ли пользователь.
     *
     * @return bool
     */
    public static function isAuthenticated(): bool
    {
        return isset($_SESSION['user_id']);
    }

    /**
     * проверка сессии пользователя, если ее нет, редирект на страницу авторизации.
     */
    public static function checkAuth()
    {
        if (empty($_SESSION['user_id'])) {
            header("Location: /users/login");
            exit;
        }
    }

    /**
     * проверка csrf токена, если сессия истекла редирект на страницу авторизации.
     * 
     * @param mixed $csrfToken сам токен
     */
    public static function checkCsrfTokenRedirect($csrfToken)
    {
        if (empty($csrfToken) || $csrfToken !== $_SESSION['csrf_token']) {
            header("Location: /users/login");
            exit;
        }
    }
    
    /**
     * проверка csrf токена, если сессия истекла выбрасывает исключение.
     * 
     * @param mixed $csrfToken сам токен
     */
    public static function checkCsrfToken($csrfToken): void
    {
        if (empty($csrfToken) || $csrfToken !== $_SESSION['csrf_token']) {
            throw new InvalidArgumentException('Сессия истекла, введите данные повторно');
        }
    }
}
