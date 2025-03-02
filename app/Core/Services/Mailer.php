<?php

namespace App\Core\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    public static function send($to, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {
            // Настройки SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP сервер
            $mail->SMTPAuth = true;
            $mail->Username = 'prog.sebo@gmail.com'; // Твой email
            $mail->Password = 'fqwm ikal cvaw syqz'; // Пароль приложения
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Отправитель и получатель
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->setFrom('prog.sebo@gmail.com', 'Your AcApp');
            $mail->addAddress($to);
            // Контент письма
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->isHTML(true);

            return $mail->send();
        } catch (Exception $e) {
            error_log('Ошибка отправки email: ' . $mail->ErrorInfo);
            return false;
        }
    }
}
