<?php
declare(strict_types=1);
/**
 * Safe Service Deletion Handler - Prefab Wooden Homes
 */
require_once __DIR__ . '/includes/auth.php';
requireAdminLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    adminVerifyCsrf();
    $serviceId = (int)($_POST['id'] ?? 0);

    if ($serviceId > 0) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM services WHERE id = :id");
            $stmt->execute(['id' => $serviceId]);
            setFlash('success', 'Construction service successfully removed.');
        } catch (\Throwable $e) {
            setFlash('error', 'Could not delete service: ' . $e->getMessage());
        }
    }
}

header('Location: ' . url('admin/services.php'));
exit;

