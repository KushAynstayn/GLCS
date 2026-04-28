<?php

require_once __DIR__ . '/../Core/Database.php';

class RBAC
{
    public static function hasPermission($permissionName)
    {
        if (!isset($_SESSION['user'])) return false;

        $db = Database::getInstance()->getConnection();

        $roleId = $_SESSION['user']['role_id'];

        $stmt = $db->prepare("
            SELECT 1 
            FROM role_permissions rp
            JOIN permissions p ON p.id = rp.permission_id
            WHERE rp.role_id = ? AND p.name = ?
            LIMIT 1
        ");

        $stmt->execute([$roleId, $permissionName]);

        return $stmt->fetchColumn() ? true : false;
    }

    public static function isAdmin()
    {
        return ($_SESSION['user']['role_id'] ?? null) == 1;
    }
}