<?php
require_once 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (!isset($_GET['date']) || !isset($_GET['subject_id']) || !isset($_GET['period'])) {
    echo json_encode(['success' => false, 'message' => 'Date, Subject ID, and Period are required']);
    exit;
}

$date = $_GET['date'];
$subjectId = $_GET['subject_id'];
$period = $_GET['period'];

try {
    // Fetch students with their attendance status for the given date, subject, and period
    // If no attendance record exists for that combination, status will be NULL
    $query = "
        SELECT s.id, s.roll_number, s.name, s.department, a.status,
            COALESCE(
                (SELECT ROUND(SUM(CASE WHEN sub_a.status = 'Present' THEN 1 ELSE 0 END) / COUNT(*) * 100, 2) 
                 FROM attendance sub_a 
                 WHERE sub_a.student_id = s.id AND sub_a.subject_id = ?
                 AND MONTH(sub_a.date) = MONTH(?) AND YEAR(sub_a.date) = YEAR(?)
                ), 0
            ) as percentage
        FROM students s 
        LEFT JOIN attendance a ON s.id = a.student_id AND a.date = ? AND a.subject_id = ? AND a.period = ?
        ORDER BY s.roll_number ASC
    ";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([$subjectId, $date, $date, $date, $subjectId, $period]);
    $records = $stmt->fetchAll();
    
    // Check if attendance has been marked for this combination
    $markedQuery = "SELECT COUNT(*) as count FROM attendance WHERE date = ? AND subject_id = ? AND period = ?";
    $markedStmt = $pdo->prepare($markedQuery);
    $markedStmt->execute([$date, $subjectId, $period]);
    $isMarked = $markedStmt->fetch()['count'] > 0;
    
    echo json_encode([
        'success' => true, 
        'date' => $date,
        'records' => $records,
        'isMarked' => $isMarked
    ]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
