<?php

namespace App\Services\Validators;

use App\Exceptions\InvalidArgumentException;

class PasswordValidator
{
    public static function validate(array $data)
    {
        if (empty($data['password_confirmation'])) 
        {
            throw new InvalidArgumentException('не передано подтверждение пароля');
        }

        if ($data['password'] !== $data['password_confirmation']) 
        {
            throw new InvalidArgumentException('пароль не совпадает');
        }
        if (mb_strlen($data['password']) < 8 and mb_strlen($data['password_confirmation']) < 8) 
        {
            throw new InvalidArgumentException('пароль не должен быть менее 8 символов');
        }
    }
}