<?php
require_once 'db.php';
set_time_limit(0); 

try {
    $pdo->beginTransaction();
    $students = $pdo->query("SELECT id FROM students")->fetchAll(PDO::FETCH_COLUMN);
    $subjects = $pdo->query("SELECT id FROM subjects")->fetchAll(PDO::FETCH_COLUMN);
    $periods = ['1st', '2nd', '3rd', '4th', '5th', '6th'];
    
    $sql = "INSERT INTO attendance (student_id, subject_id, period, date, status) VALUES ";
    $batchSize = 500;
    $params = [];
    $placeholders = [];
    $totalCount = 0;

    // Months to seed
    $monthsToSeed = [1, 3]; // January and March

    // Clear existing data for these months to avoid duplicates
    echo "Clearing old data for months " . implode(', ', $monthsToSeed) . "...\n";
    $pdo->exec("DELETE FROM attendance WHERE (MONTH(date) = 1 OR MONTH(date) = 3) AND YEAR(date) = 2026");

    foreach ($monthsToSeed as $month) {
        $daysInMonth = ($month == 1) ? 31 : 29; // March 29 is today
        echo "Seeding month $month (up to $daysInMonth days)...\n";

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = "2026-" . str_pad($month, 2, '0', STR_PAD_LEFT) . "-" . str_pad($day, 2, '0', STR_PAD_LEFT);
            $dayOfWeek = date('N', strtotime($date));
            if ($dayOfWeek >= 6) continue; // Skip weekends

            foreach ($students as $studentId) {
                foreach ($subjects as $subjectId) {
                    foreach ($periods as $period) {
                        $status = (rand(1, 100) <= 85) ? 'Present' : 'Absent';
                        
                        $placeholders[] = "(?, ?, ?, ?, ?)";
                        $params[] = $studentId;
                        $params[] = $subjectId;
                        $params[] = $period;
                        $params[] = $date;
                        $params[] = $status;
                        $totalCount++;

                        if (count($placeholders) >= $batchSize) {
                            $stmt = $pdo->prepare($sql . implode(', ', $placeholders));
                            $stmt->execute($params);
                            $placeholders = [];
                            $params = [];
                        }
                    }
                }
            }
        }
    }

    if (!empty($placeholders)) {
        $stmt = $pdo->prepare($sql . implode(', ', $placeholders));
        $stmt->execute($params);
    }
    
    $pdo->commit();
    echo json_encode(['success' => true, 'total' => $totalCount]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
