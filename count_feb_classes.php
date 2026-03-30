<?php
require_once 'db.php';

header('Content-Type: application/json');

try {
    // Count distinct (date, period) pairings for each subject in Feb 2026
    $stmt = $pdo->query("
        SELECT s.name, COUNT(DISTINCT a.date, a.period) as total_classes
        FROM subjects s
        LEFT JOIN attendance a ON s.id = a.subject_id AND MONTH(a.date) = 2 AND YEAR(a.date) = 2026
        GROUP BY s.id
    ");
    $counts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'counts' => $counts]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
