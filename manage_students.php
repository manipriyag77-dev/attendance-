<?php
require_once 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch all students
    try {
        $stmt = $pdo->query("SELECT id, roll_number, name, email, department, year FROM students ORDER BY roll_number ASC");
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'students' => $students]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Failed to fetch students: ' . $e->getMessage()]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle CRUD operations based on action parameter
    $input = json_decode(file_get_contents('php://input'), true);
    
    // In case data is sent via standard form POST instead of JSON
    if (!$input) {
        $input = $_POST;
    }

    $action = $input['action'] ?? '';

    try {
        if ($action === 'add') {
            $roll_number = $input['roll_number'] ?? '';
            $name = $input['name'] ?? '';
            $email = $input['email'] ?? null;
            $department = $input['department'] ?? 'Information Technology'; // Default fallback
            $year = $input['year'] ?? 3;

            if (empty($roll_number) || empty($name)) {
                echo json_encode(['success' => false, 'message' => 'Roll number and name are required.']);
                exit;
            }

            // Check if roll number already exists
            $checkStmt = $pdo->prepare("SELECT id FROM students WHERE roll_number = ?");
            $checkStmt->execute([$roll_number]);
            if ($checkStmt->rowCount() > 0) {
                echo json_encode(['success' => false, 'message' => 'A student with this roll number already exists.']);
                exit;
            }

            $stmt = $pdo->prepare("INSERT INTO students (roll_number, name, email, department, year) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$roll_number, $name, $email, $department, $year]);
            
            echo json_encode(['success' => true, 'message' => 'Student added successfully!', 'id' => $pdo->lastInsertId()]);

        } elseif ($action === 'edit') {
            $id = $input['id'] ?? '';
            $roll_number = $input['roll_number'] ?? '';
            $name = $input['name'] ?? '';
            $email = $input['email'] ?? null;
            $department = $input['department'] ?? 'Information Technology';
            $year = $input['year'] ?? 3;

            if (empty($id) || empty($roll_number) || empty($name)) {
                echo json_encode(['success' => false, 'message' => 'ID, roll number, and name are required.']);
                exit;
            }

            // Check if another student has this roll number
            $checkStmt = $pdo->prepare("SELECT id FROM students WHERE roll_number = ? AND id != ?");
            $checkStmt->execute([$roll_number, $id]);
            if ($checkStmt->rowCount() > 0) {
                echo json_encode(['success' => false, 'message' => 'Another student already has this roll number.']);
                exit;
            }

            $stmt = $pdo->prepare("UPDATE students SET roll_number = ?, name = ?, email = ?, department = ?, year = ? WHERE id = ?");
            $stmt->execute([$roll_number, $name, $email, $department, $year, $id]);
            
            echo json_encode(['success' => true, 'message' => 'Student updated successfully!']);

        } elseif ($action === 'delete') {
            $id = $input['id'] ?? '';
            
            if (empty($id)) {
                echo json_encode(['success' => false, 'message' => 'Student ID is required for deletion.']);
                exit;
            }
            
            // Note: If there are foreign key constraints in attendance, deleting a student might fail
            // or cascade delete depending on the DB schema. Assuming safe to delete or cascade setup.
            $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
            $stmt->execute([$id]);
            
            echo json_encode(['success' => true, 'message' => 'Student deleted successfully!']);

        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid action specified.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database operation failed: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
