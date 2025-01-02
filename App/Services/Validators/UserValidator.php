<?php

namespace App\Services\Validators;

use App\Exceptions\InvalidArgumentException;

class UserValidator
{
    public static function validateLoginData(array $data): void
    {
        if (empty($data['email']))
        {
            throw new InvalidArgumentException('Не передан email');
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('email некорректный');
        }

        if (empty($data['password']))
        {
            throw new InvalidArgumentException('Не передан пароль');
        }
    }

    public static function validateRegisterData(array $data): void
    {
        if (empty($data['name'])) {
            throw new InvalidArgumentException('не передано имя');
        }
        if (!preg_match('/^[a-zA-Z0-9]+$/', $data['name'])) // только латинские буквы и цифры.
        {
            throw new InvalidArgumentException('имя может состоять только из букв латинского алфавита и цифр!');
        }
        if (mb_strlen($data['name']) < 3 || mb_strlen($data['name']) > 20) {
            throw new InvalidArgumentException('Имя должно быть от 3 до 20 символов');
        }
        if (strpos($data['name'], ' ') !== false) {
            throw new InvalidArgumentException('Имя не должно содержать пробелов');
        }

        if (empty($data['email'])) {
            throw new InvalidArgumentException('не передано email');
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('email некорректный');
        }

        if (empty($data['password'])) {
            throw new InvalidArgumentException('не передан пароль');
        }
        if (empty($data['password_confirmation'])) {
            throw new InvalidArgumentException('не передано подтверждение пароля');
        }
        if ($data['password'] !== $data['password_confirmation']) {
            throw new InvalidArgumentException('пароль не совпадает');
        }
        if (mb_strlen($data['password']) < 8 and mb_strlen($data['password_confirmation']) < 8) {
            throw new InvalidArgumentException('пароль не должен быть менее 8 символов');
        }
    }

    public static function validateDeleteData(array $data): void
    {
        if (empty($data['password']))
        {
            throw new InvalidArgumentException('Не передан пароль');
        }

        if(mb_strlen($data['password']) < 8)
        {
            throw new InvalidArgumentException('пароль не может быть меньше 8 символов');
        }
    }
}