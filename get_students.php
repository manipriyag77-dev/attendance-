<?php
require_once 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

try {
    $stmt = $pdo->query("SELECT id, roll_number, name, department FROM students ORDER BY roll_number ASC");
    $students = $stmt->fetchAll();
    
    echo json_encode(['success' => true, 'students' => $students]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
