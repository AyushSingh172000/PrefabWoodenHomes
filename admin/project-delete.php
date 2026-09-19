<?php
/**
 * Safe Project Deletion Handler - Prefab Wooden Homes
 */
require_once __DIR__ . '/includes/auth.php';
requireAdminLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    adminVerifyCsrf();
    $projectId = (int)($_POST['id'] ?? 0);

    if ($projectId > 0) {
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM projects WHERE id = :id");
            $stmt->execute(['id' => $projectId]);
            setFlash('success', 'Project removed from portfolio.');
        } catch (\Throwable $e) {
            setFlash('error', 'Could not delete project: ' . $e->getMessage());
        }
    }
}

header('Location: ' . url('admin/projects.php'));
exit;
