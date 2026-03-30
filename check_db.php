<?php
require_once 'api/db.php';

try {
    $attendance_count = $pdo->query("SELECT COUNT(*) FROM attendance")->fetchColumn();
    $student_count = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
    $subject_count = $pdo->query("SELECT COUNT(*) FROM subjects")->fetchColumn();
    
    echo "Attendance rows: $attendance_count\n";
    echo "Student rows: $student_count\n";
    echo "Subject rows: $subject_count\n";
    
    // Show one sample attendance record if exists
    if ($attendance_count > 0) {
        $sample = $pdo->query("SELECT * FROM attendance LIMIT 1")->fetch();
        echo "Sample attendance row:\n";
        print_r($sample);
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
?>
