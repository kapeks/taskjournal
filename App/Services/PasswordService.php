<?php

namespace App\Services;

use App\Model\User;
use App\Exceptions\InvalidArgumentException;
use App\Services\Validators\PasswordValidator;

/**
 * класс отвечает за бизнес-логику пароля пользователя.
 */
class PasswordService
{
    /**
     * сбрасывание пароля и поиск пользователя по email
     * 
     * @param array $data POST данные для проверки
     */
    public static function passwordReset(array $data)
    {
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('email некорректный');
        }

        $result = User::findOneByColumn('email', $data['email']);
        if ($result === null)
        {
            throw new InvalidArgumentException();
        }

        $user = User::find($result['id']);
        $user->password_reset_code = bin2hex(random_bytes(3));
        $user->save();

        return $user;
    }

    /**
     * создание нового пароля.
     * 
     * @param array $data POST данные 
     */
    public static function passwordRecover(array $data, object $user)
    {
        PasswordValidator::validate($data);

        $user->password = password_hash($data['password'], PASSWORD_DEFAULT);
        $user->password_reset_code = null;
        $user->save();
    }
}