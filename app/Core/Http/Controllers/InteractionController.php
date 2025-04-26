<?php

namespace App\Core\Http\Controllers;

use App\Core\Models\Interaction;
use App\Core\Models\User;

class InteractionController extends Controller
{
    public function toggle($action, $module, $id)
    {
        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            return;
        }

        $userModel = new User();
        $user = $userModel->getUserByUsername($_SESSION['user']['username']);
        $userId = $user['id'];

        $interaction = new Interaction();
        $result = $interaction->toggle($userId, $id, $module, $action);
        
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($result);
        exit;
    }
}
