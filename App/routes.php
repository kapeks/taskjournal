<?php

return [
    '~^$~' => [\App\Controllers\MainController::class, 'main'],//главная страница.
    '~^users/register$~' => [\App\Controllers\UserController::class, 'register'],//регистрация пользователя.
    '~^users/activate/([a-f0-9]{64})$~' => [\App\Controllers\UserController::class, 'verifyEmail'],//активация по email.
    '~^users/login$~' => [\App\Controllers\UserController::class, 'login'],//авторизация пользователя.
    '~^users/logout$~' => [\App\Controllers\UserController::class, 'logout'],//авторизация пользователя.
    '~^users/profile$~' => [\App\Controllers\UserController::class, 'profile'],//авторизация пользователя.
    '~^users/delete$~' => [\App\Controllers\UserController::class, 'delete'],//удаление пользователя.
    '~^password/reset$~' => [\App\Controllers\PasswordController::class, 'resetRequest'],//сбрасывание пароля.
    '~^password/verifyCode$~' => [\App\Controllers\PasswordController::class, 'verifyCode'],//проверка кода для смены пароля.
    '~^password/change$~' => [\App\Controllers\PasswordController::class, 'changePassword'],//смена пароля.
    '~^tasks/create$~'=> [\App\Controllers\TaskController::class, 'create'],//интерфейс создания записи.
    '~^tasks$~'=> [\App\Controllers\TaskController::class, 'index'],//вывести все записи.
    '~^tasks/delete$~'=> [\App\Controllers\TaskController::class, 'destroy'],//удалить запись.
    '~^tasks/(\d+)/edit$~'=> [\App\Controllers\TaskController::class, 'edit'],//форма для обновления.
    '~^tasks/completed$~'=> [\App\Controllers\TaskController::class, 'completed'],//форма для обновления.
];