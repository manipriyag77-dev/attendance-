<?php
require_once 'api/db.php';
try {
    // We just grab the first subject id and first period. Use today's date or last month
    $subjectId = 1;
    $date = date('Y-m-d', strtotime('-1 month')); // Last month
    $period = '1st';

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
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Total Records: " . count($records) . "\n\n";
    if(count($records) > 0) {
        print_r($records[0]);
    } else {
        echo "No records found.";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();
}
?>
