<?php

namespace App\Services;

use App\Exceptions\InvalidArgumentException;
use App\Model\User;
use App\Services\Validators\UserValidator;

/**
 * класс отвечает за бизнес-логику пользователя.
 */
class UserService
{
    /**
     * авторизация пользователя
     * 
     * @param array $data POST данные.
     */
    public static function login(array $data)
    {
        UserValidator::validateLoginData($data);

        $user = User::findOneByColumn('email', $data['email']);
        if ($user === null) {
            throw new InvalidArgumentException('неверно введен email');
        }
        if (!password_verify($data['password'], $user['password'])) {
            throw new InvalidArgumentException('Неправильный пароль');
        }
        if ($user['is_email_verified'] == 0) {
            throw new InvalidArgumentException('пользователь не активирован');
        }

        return $user;
    }

    /**
     * метод для валидации и регистрации пользователя.
     */
    public static function register(array $data)
    {
        UserValidator::validateRegisterData($data);

        if (User::findOneByColumn('name', $data['name']) !== null) {
            throw new InvalidArgumentException('пользователь с таким именем уже существует');
        }
        if (User::findOneByColumn('email', $data['email']) !== null) {
            throw new InvalidArgumentException('пользователь с таким email уже существует');
        }

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->is_email_verified = 0;
        $user->verification_token = bin2hex(random_bytes(32));
        $user->save();

        return $user;
    }

    /**
     * активация пользователя.
     * 
     * @param string $token токен активации.
     */
    public static function activate(string $token): ?User
    {
        $name = "verification_token";
        $result = User::findOneByColumn($name, $token);

        if ($result === null) {
            throw new InvalidArgumentException('Ошибка активации. Пожалуйста, проверьте ссылку');
        }

        $user = User::find($result['id']);
        $user->is_email_verified = 1;
        $user->verification_token = null;
        $user->save();
        return $user;
    }

    /**
     * метод для валидации и удаления пользователя.
     */
    public static function delete(array $data, int $userId)
    {
        $user = User::find($userId);

        if (!$user) {
            throw new InvalidArgumentException('Пользователь не найден.');
        }

        UserValidator::validateDeleteData($data);

        if (!password_verify($data['password'], $user->password)) {
            throw new InvalidArgumentException('Неправильно введен пароль');
        }

        $user->delete();
    }
}
