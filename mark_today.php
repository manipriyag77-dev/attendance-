<?php
require_once 'api/db.php';

try {
    $students = $pdo->query("SELECT id FROM students")->fetchAll(PDO::FETCH_COLUMN);
    $subjects = $pdo->query("SELECT id FROM subjects")->fetchAll(PDO::FETCH_COLUMN);
    $periods = ['1st', '2nd', '3rd', '4th', '5th', '6th'];
    $date = date('Y-m-d'); // Today exactly
    
    $insertedCount = 0;
    
    foreach ($students as $student) {
        foreach ($subjects as $subject) {
            foreach ($periods as $period) {
                // 80% chance present
                $status = rand(1, 10) <= 8 ? 'Present' : 'Absent';
                
                // Use REPLACE INTO or INSERT IGNORE, let's use REPLACE so we force overwrite if it exists as Null or something
                $stmt = $pdo->prepare("REPLACE INTO attendance (student_id, subject_id, period, date, status) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$student, $subject, $period, $date, $status]);
                $insertedCount++;
            }
        }
    }
    
    echo "SUCCESS: Marked $insertedCount records for TODAY ($date) across all periods so it stops showing Unmarked!";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
?>
