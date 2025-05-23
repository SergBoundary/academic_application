<?php

namespace App\Core\Models;

use App\Core\Models\Model;

class ResearchStructure extends Model
{
    public function getDisciplines()
    {
        $sql = "SELECT `id`, `en`, `pl`, `uk`, `ru`
                FROM `research_disciplines` 
                ORDER BY `{$this->language}`";

        return $this->query($sql);
    }
    public function getFields()
    {
        $sql = "SELECT 
                  `rf`.`id`, `rf`.`en`, `rf`.`pl`, `rf`.`uk`, `rf`.`ru`,
                  `rd`.`{$this->language}` AS `discipline`
                FROM `research_fields` AS `rf`
                INNER JOIN `research_disciplines` AS `rd`
                  ON `rd`.`id` = `rf`.`research_discipline_id`
                ORDER BY `rd`.`{$this->language}`, `rf`.`{$this->language}`";

        return $this->query($sql);
    }
    public function getAreas()
    {
        $sql = "SELECT 
                  `ra`.`id`, `ra`.`en`, `ra`.`pl`, `ra`.`uk`, `ra`.`ru`,
                  `rf`.`{$this->language}` AS `field`,
                  `rd`.`{$this->language}` AS `discipline`
                FROM `research_areas` AS `ra`
                INNER JOIN `research_fields` AS `rf`
                  ON `rf`.`id` = `ra`.`research_field_id`
                INNER JOIN `research_disciplines` AS `rd`
                  ON `rd`.`id` = `rf`.`research_discipline_id`
                ORDER BY `rd`.`{$this->language}`, `rf`.`{$this->language}`, `ra`.`{$this->language}`";

        return $this->query($sql);
    }

    public function getTypes()
    {
        $sql = "SELECT `id`, `en`, `pl`, `uk`, `ru`
                FROM `research_types` 
                ORDER BY `{$this->language}`";

        return $this->query($sql);
    }

    public function getElements()
    {
        $sql = "SELECT 
                  `pe`.`id`, `pe`.`research_post_type_id`, `pe`.`en`, `pe`.`pl`, `pe`.`uk`, `pe`.`ru`,
                  `pt`.`{$this->language}` AS `type`
                FROM `research_elements` AS `pe`
                INNER JOIN `research_types` AS `pt`
                  ON `pt`.`id` = `pe`.`research_post_type_id`
                ORDER BY `pe`.`{$this->language}`, `pt`.`{$this->language}`";

        return $this->query($sql);
    }

    public function getByDiscipline(int $disciplineId): array
    {
        $sql = "SELECT `id`, `{$this->language}` AS `name`
                FROM `research_fields` 
                WHERE `research_discipline_id` = :disciplineId
                ORDER BY `{$this->language}`";

        return $this->query($sql, ['disciplineId' => $disciplineId]);
    }

    // public function getAllPosts()
    // {
    //     $sql = "SELECT 
    //               `tr`.`id`, `tr`.`user_id`, `tr`.`type_id`, `tr`.`title`, `tr`.`content`, `tr`.`category_id`, `tr`.`locked`, `tr`.`created_at`, `tr`.`updated_at`,
    //               `tu`.`username`, `tu`.`name`, `tu`.`surname`, `tu`.`avatar`,
    //               `trc`.`{$this->language}` AS `category_name`
    //             FROM `research_posts` AS `tr`
    //             INNER JOIN `research_post_categories` AS `trc`
    //               ON `trc`.`id` = `tr`.`category_id`
    //             INNER JOIN `users` AS `tu`
    //               ON `tu`.`id` = `tr`.`user_id`
    //             ORDER BY `tr`.`user_id`, `tr`.`created_at` ASC";

    //     return $this->query($sql);
    // }

    // public function getPostById($id)
    // {
    //     $sql = "SELECT 
    //                 `tr`.`id`, `tr`.`user_id`, `tr`.`title`, `tr`.`category_id`, `tr`.`content`, `tr`.`file_path`, `tr`.`created_at`, `tr`.`updated_at`,
    //                 `ta`.`username`, `ta`.`name`, `ta`.`surname`, `ta`.`avatar`,
    //                 `trc`.`{$this->language}` AS `category_name`
    //             FROM `research_posts` AS `tr` 
    //             INNER JOIN `users` AS `ta`
    //               ON `ta`.`id` = `tr`.`user_id`
    //             INNER JOIN `research_post_categories` AS `trc`
    //               ON `trc`.`id` = `tr`.`category_id`
    //             WHERE `tr`.`id` = :id AND `tr`.`locked` = 0";

    //     $result = $this->query($sql, ['id' => $id]);
    //     return $result[0] ?? null;
    // }

    // Добавление нового перевода
    public function createStructure(string $form, array $data): bool
    {
        // debug($form, 0);
        // debug($data, 0);
        
        $table = [
            'discipline' => 'research_disciplines',
            'field' => 'research_fields',
            'area' => 'research_areas',
            'type' => 'research_types',
            'element' => 'research_elements',
        ];

        // Предположим, что $data содержит столбцы: ru, en, pl, ua и т.д.
        $columns = array_keys($data);
        $placeholders = array_map(fn($col) => ":{$col}", $columns);
        // debug($columns, 0);
        // debug($placeholders, 0);
        $sql = "INSERT INTO " . $table[$form] . " (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ")";
        $params = $data;
        // debug($sql, 0);
        // debug($params, 1);
        return $this->execute($sql, $params);
    }

    // public function updatePost($id, $title, $content, $category)
    // {
    //     $sql = "UPDATE `research_posts` 
    //             SET `title` = :title, `content` = :content, `category_id` = :category_id 
    //             WHERE id = :id";

    //     return $this->execute($sql, [
    //         'id' => $id,
    //         'title' => $title,
    //         'content' => $content,
    //         'category_id' => $category
    //     ]);
    // }

    public function updateLock(int $id, int $locked): bool
    {
        return $this->execute(
            "UPDATE research_posts SET locked = :locked WHERE id = :id",
            ['locked' => $locked, 'id' => $id]
        );
    }
}
