<?php

namespace App\Services\Validators;

use App\Exceptions\InvalidArgumentException;

class TaskValidator
{
    public static function validate(array $data): void
    {
        if (empty($data['name']))
        {
            throw new InvalidArgumentException('введите название');
        }
        if (strlen($data['name']) > 255) {
            throw new InvalidArgumentException('Название слишком длинное, максимум 255 символов');
        }
        if (empty($data['text']))
        {
            throw new InvalidArgumentException('введите описание');
        }
        if (strlen($data['text']) > 1000) {
            throw new InvalidArgumentException('Описание слишком длинное, максимум 1000 символов');
        }
    }
}