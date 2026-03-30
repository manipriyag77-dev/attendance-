<?php
$file = 'schema.sql';
$content = file_get_contents($file);

// Add password column to INSERT statement
$content = str_replace(
    "INSERT INTO `students` (`roll_number`, `name`, `department`, `year`) VALUES",
    "INSERT INTO `students` (`roll_number`, `password`, `name`, `department`, `year`) VALUES",
    $content
);

// Match all student value tuples: ('2023IT01', 'Aarav Patel', 'Information Technology', 3)
preg_match_all("/\('([^']+)',\s*'([^']+)',\s*'([^']+)',\s*(\d+)\)/", $content, $matches, PREG_SET_ORDER);

foreach ($matches as $match) {
    $fullMatch = $match[0];
    $rollNumber = $match[1];
    $hash = password_hash($rollNumber, PASSWORD_DEFAULT);
    $replacement = "('$rollNumber', '$hash', '{$match[2]}', '{$match[3]}', {$match[4]})";
    $content = str_replace($fullMatch, $replacement, $content);
}

file_put_contents($file, $content);
echo "schema.sql updated successfully.\n";

// Also run database update on attendance_db
require_once 'api/db.php';
try {
    // Check if column exists
    $result = $pdo->query("SHOW COLUMNS FROM `students` LIKE 'password'");
    if ($result->rowCount() == 0) {
        $pdo->exec("ALTER TABLE `students` ADD COLUMN `password` varchar(255) NOT NULL AFTER `roll_number`");
        echo "Added password column to students table.\n";
    }

    $stmt = $pdo->query("SELECT id, roll_number FROM students");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $updateStmt = $pdo->prepare("UPDATE students SET password = ? WHERE id = ?");
    foreach ($students as $student) {
        $hash = password_hash($student['roll_number'], PASSWORD_DEFAULT);
        $updateStmt->execute([$hash, $student['id']]);
    }
    echo "Updated all student passwords in the database.\n";
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
?>
