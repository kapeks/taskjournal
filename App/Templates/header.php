<!--файл с головой шаблона-->
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>дневник задач</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="icon" href="/public/img/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="/public/css/styles.css">
</head>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark position-fixed w-100 top-0">
    <div class="container-fluid">
        <!-- Название сайта -->
        <a class="navbar-brand" <?= $_SERVER['REQUEST_URI'] === '/' ? 'active' : '' ?>" aria-current="page" href="/">Task Journal</a>

        <!-- Кнопка для мобильной версии -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <?php if ($isAuthenticated): ?>
            <!-- Меню навигации -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) === '/tasks' ? 'active' : '' ?>" aria-current="page" href="/tasks">Задачи</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $_SERVER['REQUEST_URI'] === '/tasks/create' ? 'active' : '' ?>" href="/tasks/create">Добавить</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $_SERVER['REQUEST_URI'] === '/users/profile' ? 'active' : '' ?>" href="/users/profile">Профиль</a>
                    </li>
                </ul>

                <!-- Сортировка и Ссылка Logout  -->
                <!-- Сортировка: показывается только на странице "Задачи" -->

                <?php
                $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

                if ($urlPath === '/tasks'): ?>
                    <form action="/tasks" method="GET" class="d-flex align-items-center">
                        <label for="sort-select" class="me-2 text-white mb-0">Сортировать:</label>
                        <select
                            id="sort-select"
                            name="filter"
                            class="form-select form-select-sm"
                            style="width: 150px;"
                            onchange="this.form.submit()">
                            <option value="all" <?= $filter === 'all' ? 'selected' : '' ?>>все</option>
                            <option value="active" <?= $filter === 'active' ? 'selected' : '' ?>>активные</option>
                            <option value="completed" <?= $filter === 'completed' ? 'selected' : '' ?>>выполненные</option>
                            <option value="old" <?= $filter === 'old' ? 'selected' : '' ?>>сначала старые</option>
                        </select>
                    </form>
                <?php endif; ?>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="/users/logout">Выход</a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</nav>




<body style="padding-top: 30px;">