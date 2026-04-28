<?php

require_once __DIR__ . '/../Helpers/RBAC.php';

class PermissionMiddleware
{
    public static function check($permission)
    {
        if (!RBAC::hasPermission($permission)) {
            http_response_code(403);
            die("403 Unauthorized - Missing Permission: $permission");
        }
    }
}