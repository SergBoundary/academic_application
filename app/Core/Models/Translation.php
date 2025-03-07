<?php

namespace App\Core\Models;

class Translation extends Model
{
    protected string $table = 'translations';

    // Получение всех переводов
    public function getAll(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->query($sql);
    }

    // Получение перевода по ключу
    public function getByKey(string $key): ?array
    {
        $sql = "SELECT * FROM {$this->table} WHERE key_name = :key LIMIT 1";
        $result = $this->query($sql, ['key' => $key]);
        return $result ? $result[0] : null;
    }

    // Обновление перевода (обновляем все столбцы, например, ru, en, pl, ua)
    public function updateTranslation(string $key, array $data): bool
    {
        // Формируем динамически SET-часть запроса
        $setParts = [];
        $params = [];
        foreach ($data as $lang => $value) {
            $setParts[] = "`{$lang}` = :{$lang}";
            $params[$lang] = $value;
        }
        $params['key'] = $key;
        $setClause = implode(', ', $setParts);
        $sql = "UPDATE {$this->table} SET {$setClause} WHERE key_name = :key";
        return $this->execute($sql, $params);
    }

    // Добавление нового перевода
    public function createTranslation(string $key, array $data): bool
    {
        // debug($key);
        // debug($data);die;

        // Предположим, что $data содержит столбцы: ru, en, pl, ua и т.д.
        $columns = array_merge(['key_name'], array_keys($data));
        $placeholders = array_map(fn($col) => ":{$col}", $columns);
        $sql = "INSERT INTO {$this->table} (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ")";
        $params = array_merge(['key_name' => $key], $data);
        return $this->execute($sql, $params);
    }

    // Удаление перевода
    public function deleteTranslation(string $key): bool
    {
        $sql = "DELETE FROM {$this->table} WHERE key_name = :key";
        return $this->execute($sql, ['key' => $key]);
    }
}
