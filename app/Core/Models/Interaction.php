<?php

namespace App\Core\Models;

class Interaction extends Model
{
    public function toggle($userId, $postId, $postType, $action)
    {
        $exists = $this->query("SELECT * FROM `post_interactions` WHERE `user_id` = :user_id AND `post_id` = :post_id AND `post_type` = :post_type", [
            'user_id' => $userId,
            'post_id' => $postId,
            'post_type' => $postType
        ]);

        if (empty($exists)) {
            $this->execute("INSERT INTO `post_interactions` (`user_id`, `post_id`, `post_type`, `{$action}`) VALUES (:user_id, :post_id, :post_type, 1)", [
                'user_id' => $userId,
                'post_id' => $postId,
                'post_type' => $postType
            ]);
        } else {

            $row = $exists[0];
            $newValue = $row[$action] ? 0 : 1;

            // Если переключение лайк/дизлайк
            if ($action === 'liked' && $row['disliked']) {
                $this->execute("UPDATE `post_interactions` SET `liked` = 1, `disliked` = 0 WHERE `id` = :id", [
                    'id' => $row['id']
                ]);
            } elseif ($action === 'disliked' && $row['liked']) {
                $this->execute("UPDATE `post_interactions` SET `liked` = 0,  `disliked` = 1 WHERE `id` = :id", [
                    'id' => $row['id']
                ]);
            } else {
                $this->execute("UPDATE `post_interactions` SET `{$action}` = :val WHERE `id` = :id", [
                    'val' => $newValue,
                    'id' => $row['id']
                ]);
            }
        }

        $sqlAction = "SELECT SUM(`liked`) AS `liked`, SUM(`disliked`) AS `disliked`, SUM(`bookmarked`) AS `bookmarked`, SUM(`subscribed`) AS `subscribed`, SUM(`shared`) AS `shared` 
                FROM `post_interactions` 
                WHERE `user_id` = :user_id AND `post_id` = :post_id AND `post_type` = :post_type";
        $resultAction = $this->query($sqlAction, [
            'user_id' => $userId,
            'post_id' => $postId,
            'post_type' => $postType
        ]);
        $rowAction = $resultAction[0] ?? [];

        $sqlCount = "SELECT SUM(`liked`) AS `liked`, SUM(`disliked`) AS `disliked`, SUM(`bookmarked`) AS `bookmarked`, SUM(`subscribed`) AS `subscribed`, SUM(`shared`) AS `shared` 
                FROM `post_interactions` 
                WHERE `post_id` = :post_id AND `post_type` = :post_type";
        $resultCount = $this->query($sqlCount, [
            'post_id' => $postId,
            'post_type' => $postType
        ]);
        $rowCount = $resultCount[0] ?? [];

        $updatedStatus = [
            'liked' => (int) ($rowAction['liked'] ?? 0),
            'likedCount' => (int) ($rowCount['liked'] ?? 0),
            'disliked' => (int) ($rowAction['disliked'] ?? 0),
            'dislikedCount' => (int) ($rowCount['disliked'] ?? 0),
            'bookmarked' => (int) ($rowAction['bookmarked'] ?? 0),
            'bookmarkedCount' => (int) ($rowCount['bookmarked'] ?? 0),
            'subscribed' => (int) ($rowAction['subscribed'] ?? 0),
            'subscribedCount' => (int) ($rowCount['subscribed'] ?? 0),
            'shared' => (int) ($rowAction['shared'] ?? 0),
            'sharedCount' => (int) ($rowCount['shared'] ?? 0),
        ];

        return $updatedStatus;
    }

    public function statPostsList($postType)
    {
        $sql = "SELECT `post_id`, SUM(`liked`) AS `liked`, SUM(`disliked`) AS `disliked`, SUM(`bookmarked`) AS `bookmarked`, SUM(`subscribed`) AS `subscribed`, SUM(`shared`) AS `shared` 
                FROM `post_interactions` 
                WHERE `post_type` = :post_type
                GROUP BY `post_id`
                ORDER BY `post_id`";

        $result = $this->query($sql, ['post_type' => $postType]);

        $statCount = [];
        foreach ($result as $value) {
            $statCount[$value['post_id']]['liked'] = $value['liked'];
            $statCount[$value['post_id']]['disliked'] = $value['disliked'];
            $statCount[$value['post_id']]['bookmarked'] = $value['bookmarked'];
            $statCount[$value['post_id']]['subscribed'] = $value['subscribed'];
            $statCount[$value['post_id']]['shared'] = $value['shared'];
        }

        return $statCount;
    }

    public function statUserPostsList($userId, $postType)
    {
        $sql = "SELECT `post_id`, SUM(`liked`) AS `liked`, SUM(`disliked`) AS `disliked`, SUM(`bookmarked`) AS `bookmarked`, SUM(`subscribed`) AS `subscribed`, SUM(`shared`) AS `shared` 
                FROM `post_interactions` 
                WHERE `user_id` = :user_id AND `post_type` = :post_type
                GROUP BY `post_id`
                ORDER BY `post_id`";

        $result = $this->query($sql, ['user_id' => $userId, 'post_type' => $postType]);

        $statAction = [];
        foreach ($result as $value) {
            $statAction[$value['post_id']]['liked'] = $value['liked'];
            $statAction[$value['post_id']]['disliked'] = $value['disliked'];
            $statAction[$value['post_id']]['bookmarked'] = $value['bookmarked'];
            $statAction[$value['post_id']]['subscribed'] = $value['subscribed'];
            $statAction[$value['post_id']]['shared'] = $value['shared'];
        }

        return $statAction;
    }

    public function statPost($postId)
    {
        $sql = "SELECT `post_id`, SUM(`liked`) AS `liked`, SUM(`disliked`) AS `disliked`, SUM(`bookmarked`) AS `bookmarked`, SUM(`subscribed`) AS `subscribed`, SUM(`shared`) AS `shared` 
                FROM `post_interactions` 
                WHERE `post_id` = :post_id
                GROUP BY `post_id`";

        return $this->query($sql, ['post_id' => $postId]);
    }

    public function statCommentsList($postType)
    {
        if ($postType == 'research') {
            $sql = "SELECT `rp`.`id`, COUNT(`dpc`.`research_id`) AS count
                    FROM `research_posts` AS `rp`
                    LEFT JOIN `discussions` AS `dpc`
                      ON `dpc`.`research_id` = `rp`.`id`
                    GROUP BY `rp`.`id`";
        } elseif ($postType == 'discussion') {
            $sql = "SELECT `dp`.`discussion_id` AS id, COUNT(`dpc`.`discussion_id`) AS count 
                    FROM `discussions` AS `dp`
                    LEFT JOIN `discussions` AS `dpc`
                      ON `dpc`.`id` = `dp`.`id`
                    WHERE `dp`.`discussion_id` > 0 
                    GROUP BY `dp`.`discussion_id`";
        }

        $result = $this->query($sql);

        $сommentCount = [];
        foreach ($result as $value) {
            $сommentCount[$value['id']] = $value['count'];
        }

        return $сommentCount;
    }

    public function statUserCommentsList($userId, $postType)
    {
        if ($postType == 'research') {
            $sql = "SELECT `rp`.`id`, COUNT(`dpc`.`research_id`) AS count
                    FROM `research_posts` AS `rp`
                    LEFT JOIN `discussions` AS `dpc`
                      ON `dpc`.`research_id` = `rp`.`id`
                    WHERE `dpc`.`user_id` = :user_id
                    GROUP BY `rp`.`id`";
        } elseif ($postType == 'discussion') {
            $sql = "SELECT `dp`.`discussion_id` AS id, COUNT(`dpc`.`discussion_id`) AS count 
                    FROM `discussions` AS `dp`
                    LEFT JOIN `discussions` AS `dpc`
                      ON `dpc`.`id` = `dp`.`id`
                    WHERE `dpc`.`user_id` = :user_id AND `dp`.`discussion_id` > 0 
                    GROUP BY `dp`.`discussion_id`";
        }

        $result = $this->query($sql, ['user_id' => $userId]);

        $сommentAction = [];
        foreach ($result as $value) {
            $сommentAction[$value['id']] = $value['count'];
        }

        return $сommentAction;
    }
}
