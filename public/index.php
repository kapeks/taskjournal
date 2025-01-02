<?php

use Dotenv\Dotenv;

try {

    require __DIR__ . '/../vendor/autoload.php';

    // Создаём объект Dotenv и загружаем переменные
    $dotenv = Dotenv::createImmutable(__DIR__. '/../');
    $dotenv->load();
    foreach ($_ENV as $key => $value) {
        putenv("$key=$value");
    }
    

    // Инициализация сессии
    session_start();

    // Генерация CSRF-токена, если он отсутствует
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    $route = $_GET['route'] ?? ''; //передаем данные роутинга.
    $routes = require __DIR__ . '/../App/routes.php'; //сохраняем массив с рег-выражениями.

    $isRouteFound = false; //нахождение маршрута, задаем флаг.
    foreach ($routes as $pattern => $controllerAndAction) //перебираем рег-выражение и контроллер c экшеном.
    {
        preg_match($pattern, $route, $matches); //проверяем на соответсвие рег-выражению.
        if (!empty($matches)) {
            $isRouteFound = true; //если совпадение есть,то меняем флаг.
            break;
        }
    }

    if (!$isRouteFound)  //false - совпадений c маршрутом нет, вывод информации об этом.
    {
        throw new \App\Exceptions\NotFoundException('ошибка 404');
    }

    unset($matches[0]); //удаляем индекс с рег-выражением, оставляем лишь данные полученые в маске.

    $controllerName = $controllerAndAction[0]; //имя контроллера.
    $actionName = $controllerAndAction[1]; //имя экшена.

    $controller = new $controllerName(); //создаем обьект
    $controller->$actionName(...$matches); //вызываем метод и задаем аргумент при помощи массива.
} catch (\App\Exceptions\NotFoundException $e) {
    $view = new \App\Views\View(__DIR__ . '/../App/Templates/errors/');
    $view->render('404.php', ['error' => $e->getMessage()], 404);
} catch (\App\Exceptions\DbException $e) {
    $view = new \App\Views\View(__DIR__ . '/../App/Templates/errors/');
    $view->render('500.php', ['error' => $e->getMessage()], 500);
}
