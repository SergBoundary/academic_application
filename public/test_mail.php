<?php

require_once ROOT . '/vendor/autoload.php';

use App\Core\Services\Mailer;

$result = Mailer::send('recipient@example.com', 'Тестовое письмо', 'Привет, это тест!');
echo $result ? 'Письмо отправлено!' : 'Ошибка отправки!';
