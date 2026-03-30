<?php
require_once 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

try {
    $stmt = $pdo->query("SELECT id, code, name, department FROM subjects ORDER BY code ASC");
    $subjects = $stmt->fetchAll();
    
    echo json_encode(['success' => true, 'subjects' => $subjects]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
