<?php

namespace App\Core\Models;

class Statistics extends Model
{
    public function statAllUsers()
    {
        $sql = "SELECT `id` FROM `users`";

        $users = $this->query($sql);

        $stat = [];
        foreach ($users as $user) {
            $stat[$user['id']]['research'] = $this->statUserResearchPost($user['id']);
            $stat[$user['id']]['discussion'] = $this->statUserDiscussionPost($user['id']);
        }

        return $stat;
    }

    public function statUserResearchPost($userId)
    {
        $sql = "SELECT COUNT(`id`) AS `posted` 
                FROM `research_posts` 
                WHERE `user_id` = :user_id";

        $postsCount = $this->query($sql, ['user_id' => $userId]);

        $sql = "SELECT SUM(`pi`.`liked`) AS `liked`, SUM(`pi`.`disliked`) AS `disliked`, SUM(`pi`.`bookmarked`) AS `bookmarked`, SUM(`pi`.`subscribed`) AS `subscribed`, SUM(`pi`.`shared`) AS `shared` 
                FROM `post_interactions` AS `pi`
                LEFT JOIN `research_posts` AS `rp`
                  ON `rp`.`id` = `pi`.`post_id`
                WHERE `rp`.`user_id` = :user_id AND `pi`.`post_type` = 'research'";

        $interactionsCount = $this->query($sql, ['user_id' => $userId]);

        $stat = [];
        $stat['posted'] = $postsCount[0]['posted'] ?? 0;
        $stat['liked'] = $interactionsCount[0]['liked'] ?? 0;
        $stat['disliked'] = $interactionsCount[0]['disliked'] ?? 0;
        $stat['shared'] = $interactionsCount[0]['shared'] ?? 0;
        $stat['bookmarked'] = $interactionsCount[0]['bookmarked'] ?? 0;
        $stat['subscribed'] = $interactionsCount[0]['subscribed'] ?? 0;

        return $stat;
    }

    public function statUserDiscussionPost($userId)
    {
        $sql = "SELECT COUNT(`id`) AS `posted` 
                FROM `discussions` 
                WHERE `user_id` = :user_id";

        $postsCount = $this->query($sql, ['user_id' => $userId]);

        $sql = "SELECT SUM(`pi`.`liked`) AS `liked`, SUM(`pi`.`disliked`) AS `disliked`, SUM(`pi`.`bookmarked`) AS `bookmarked`, SUM(`pi`.`subscribed`) AS `subscribed`, SUM(`pi`.`shared`) AS `shared` 
                FROM `post_interactions` AS `pi`
                LEFT JOIN `discussions` AS `dp`
                  ON `dp`.`id` = `pi`.`post_id`
                WHERE `dp`.`user_id` = :user_id AND `pi`.`post_type` = 'discussion'";

        $interactionsCount = $this->query($sql, ['user_id' => $userId]);

        $stat = [];
        $stat['posted'] = $postsCount[0]['posted'] ?? 0;
        $stat['liked'] = $interactionsCount[0]['liked'] ?? 0;
        $stat['disliked'] = $interactionsCount[0]['disliked'] ?? 0;
        $stat['shared'] = $interactionsCount[0]['shared'] ?? 0;
        $stat['bookmarked'] = $interactionsCount[0]['bookmarked'] ?? 0;
        $stat['subscribed'] = $interactionsCount[0]['subscribed'] ?? 0;

        return $stat;
    }
}
