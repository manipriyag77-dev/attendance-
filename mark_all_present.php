<?php
require_once 'api/db.php';

try {
    // Generate dummy attendance records for the past 30 days for all students!
    
    $students = $pdo->query("SELECT id FROM students")->fetchAll(PDO::FETCH_COLUMN);
    $subjects = $pdo->query("SELECT id FROM subjects")->fetchAll(PDO::FETCH_COLUMN);
    $periods = ['1st', '2nd', '3rd', '4th', '5th', '6th'];
    
    $insertedCount = 0;
    
    for ($i = 0; $i < 30; $i++) {
        $date = date('Y-m-d', strtotime("-$i days"));
        
        // Include all days, even weekends, so the default dashboard date (today) shows data!
        // if (date('N', strtotime($date)) >= 6) continue;
        
        foreach ($students as $student) {
            foreach ($subjects as $subject) {
                // creating attendance for 2 periods per day for demonstration
                foreach (['1st', '2nd'] as $period) {
                    $status = rand(1, 100) <= 85 ? 'Present' : 'Absent';
                    
                    $stmt = $pdo->prepare("INSERT IGNORE INTO attendance (student_id, subject_id, period, date, status) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$student, $subject, $period, $date, $status]);
                    
                    if ($stmt->rowCount() > 0) {
                        $insertedCount++;
                    }
                }
            }
        }
    }
    
    echo "SUCCESS: Generated dummy attendance data! Total new rows inserted: " . $insertedCount;
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
?>
