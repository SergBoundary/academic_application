<?php

namespace App\Core\Helpers;

class Flash
{
    public static function set(string $title, string $text = '', string $icon = 'info'): void
    {
        $_SESSION['flash'] = [
            'title' => $title,
            'text' => $text,
            'icon' => $icon
        ];
    }

    public static function render(): void
    {
        if (!isset($_SESSION['flash'])) return;

        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);

        echo "<script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: " . json_encode($flash['title']) . ",
                    text: " . json_encode($flash['text']) . ",
                    icon: " . json_encode($flash['icon']) . "
                });
            });
        </script>";
    }
}
