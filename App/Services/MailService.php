<?php

namespace App\Services;

/**
 * класс отвечает за отправку почты.
 * 
 * @param mixed $email почта получателя.
 * @param mixed $token токен подтверждения.
 */
class MailService
{
    /**
     * письмо для подтверждения почты.
     */
    public static function sendVerificationEmail($email, $token)
    {
        $verificationLink = getenv('APP_URL') . "/users/activate/$token";

        mail(
            $email,
            'Подтверждение Email',
            "Перейдите по ссылке для подтверждения: $verificationLink",
            "From: y38025841@gmail.com"
        );
    }

    /**
     * письмо для сброса пароля.
     */
    public static function sendResetPassword($email, $token)
    {
        mail(
            $email,
            'Восстановление пароля',
            "Ваш код для восстановления: $token",
            "From: y38025841@gmail.com"
        );
    }
}
