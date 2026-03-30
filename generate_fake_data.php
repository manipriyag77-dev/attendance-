<?php
require_once 'db.php';

// Script to generate fake attendance data for the past 30 days
// This allows you to select ANY past date and see a realistic attendance report!

header('Content-Type: text/html');

try {
    // 1. Get all students
    $stmt = $pdo->query("SELECT id FROM students");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2. Get all subjects
    $stmt = $pdo->query("SELECT id FROM subjects");
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if(empty($students) || empty($subjects)) {
        echo "<h1>Error: Please make sure you have added at least one Student and Subject in the Manage sections!</h1>";
        exit;
    }

    echo "<h2>Starting to generate fake data...</h2><ul>";

    $pdo->beginTransaction();

    // Loop backwards for 30 days starting from yesterday
    for($i = 1; $i <= 30; $i++) {
        // Find out the date
        $date = date('Y-m-d', strtotime("-$i days"));
        
        // Skip weekends (optional realism)
        $dayOfWeek = date('N', strtotime($date));
        if($dayOfWeek >= 6) continue; // 6 = Saturday, 7 = Sunday
        
        foreach($subjects as $subject) {
            // Let's generate data for basically just the "1st" period to mock it quickly
            $period = "1st";
            
            // Check if attendance already exists for this combo
            $checkStmt = $pdo->prepare("SELECT id FROM attendance WHERE date = ? AND subject_id = ? AND period = ? LIMIT 1");
            $checkStmt->execute([$date, $subject['id'], $period]);
            if($checkStmt->rowCount() > 0) {
                // Skip if already generated for this exact class
                continue; 
            }

            // Generate records for each student
            $stmtInsert = $pdo->prepare("INSERT INTO attendance (student_id, subject_id, period, date, status) VALUES (?, ?, ?, ?, ?)");
            
            foreach($students as $student) {
                // 85% chance of being Present, 15% Absent
                $status = (rand(1, 100) <= 85) ? 'Present' : 'Absent';
                
                $stmtInsert->execute([$student['id'], $subject['id'], $period, $date, $status]);
            }
        }
        echo "<li>Generated realistic attendance for: <strong>$date</strong></li>";
    }

    $pdo->commit();
    echo "</ul><h2>✅ Success! The entire past month has been filled with realistic student reports. Go check your dashboard!</h2>";

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "<h2>❌ Database Error: " . $e->getMessage() . "</h2>";
}
?>
