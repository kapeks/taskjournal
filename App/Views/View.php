<?php

namespace App\Views;

use App\Middleware\AuthMiddleware;

class View
{
    private $templatePath;

    public function __construct(string $templatePath)
    {
        $this->templatePath = $templatePath;
    }

    /**
     * @param string $template название файла.
     * @param array<string, mixed> $data данные для отображения.
     * @param int $code возвращаемый код для страницы, по умолчанию 200.
     */
    public function render(string $template, array $data = [], int $code = 200): void
    {
        http_response_code($code);
        $data['isAuthenticated'] = AuthMiddleware::isAuthenticated(); //глобальная проверка на авторизацию пользователя.
        extract($data);
        require $this->templatePath . $template;
    }
}