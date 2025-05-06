<?php 

namespace App\Core\Services;

class FileStorageService
{
    // относительный путь в /storage
    private static string $baseDir = ROOT . '/storage/uploads/';
    private static string $publicAlias = '/uploads/';

    public static function put(string $subdir, array $file): string
    {
        // Например, $subdir = 'posts' или 'images'
        $dir = self::$baseDir . trim($subdir, '/') . '/';
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $name = uniqid() . '.' . $ext;
        move_uploaded_file($file['tmp_name'], $dir . $name);

        return $subdir . '/' . $name; // => сохраняется в БД
    }

    /**
     * Сохраняет произвольный текст в файл и возвращает относительный путь.
     *
     * @param string $subdir    подпапка в storage/uploads (например, 'posts')
     * @param string $text      тело файла
     * @param string|null $existingPath если нужно переписать существующий файл
     * @return string           относительный путь, сохраняемый в БД
     */
    public static function saveString(string $subdir, string $text, ?string $existingPath = null): string
    {
        $dir = self::$baseDir . trim($subdir, '/') . '/';
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        // Если у записи уже есть файл, переписываем его; иначе — генерируем новое имя
        if ($existingPath) {
            $filename = basename($existingPath);
        } else {
            $filename = uniqid() . '.txt';
        }

        file_put_contents($dir . $filename, $text);

        // Возвращаем путь относительно storage/uploads
        return trim($subdir, '/') . '/' . $filename;
    }

    public static function getUrl(string $path): string
    {
        // возвращает публичный URL, например /files/posts/...
        return self::$publicAlias . ltrim($path, '/');
    }
}
