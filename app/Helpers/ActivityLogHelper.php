<?php 
namespace App\Helpers;

use App\UserActivityLog;

class ActivityLogHelper
{
    public static function log($userId, $action, $module = null, $description = null, $proposalId = null)
    {
        UserActivityLog::create([
            'user_id' => $userId,
            'proposal_id' => $proposalId,
            'action' => $action,
            'module' => $module,
            'description' => $description,
        ]);
    }
}
