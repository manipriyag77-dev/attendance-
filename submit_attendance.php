<?php
require_once 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['date']) || !isset($data['subject_id']) || !isset($data['period']) || !isset($data['attendance']) || !is_array($data['attendance'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid data format']);
    exit;
}

$date = $data['date'];
$subjectId = $data['subject_id'];
$period = $data['period'];
$attendanceList = $data['attendance'];

try {
    $pdo->beginTransaction();
    
    // First, delete any existing attendance for this date, subject, AND period to allow updates
    $stmtDelete = $pdo->prepare("DELETE FROM attendance WHERE date = ? AND subject_id = ? AND period = ?");
    $stmtDelete->execute([$date, $subjectId, $period]);
    
    // Insert new attendance records
    $stmtInsert = $pdo->prepare("INSERT INTO attendance (student_id, subject_id, period, date, status) VALUES (?, ?, ?, ?, ?)");
    
    foreach ($attendanceList as $studentId => $status) {
        $stmtInsert->execute([$studentId, $subjectId, $period, $date, $status]);
    }
    
    $pdo->commit();
    echo json_encode(['success' => true, 'message' => 'Attendance saved successfully']);
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
