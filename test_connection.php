<?php
require_once 'api/db.php';
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'message' => 'API is reachable and database is connected.',
    'db_status' => isset($pdo) ? 'Connected' : 'Failed'
]);
?>
