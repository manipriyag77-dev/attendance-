<?php
require_once 'db.php';
header('Content-Type: application/json');

try {
    // 1. Get 4 random students
    $students = $pdo->query("SELECT id FROM students ORDER BY RAND() LIMIT 4")->fetchAll(PDO::FETCH_COLUMN);
    
    // 2. For each student, find some 'Present' records in Feb 2026 and change them to 'Absent'
    // This will force their percentage to drop below 75%
    foreach ($students as $id) {
        $stmt = $pdo->prepare("
            UPDATE attendance 
            SET status = 'Absent' 
            WHERE student_id = ? AND MONTH(date) = 2 AND YEAR(date) = 2026
            ORDER BY RAND() 
            LIMIT 15
        ");
        $stmt->execute([$id]);
    }
    
    echo json_encode(['success' => true, 'message' => 'Forced shortage for 4 students in Feb 2026']);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
