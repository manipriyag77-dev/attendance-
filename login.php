<?php
require_once 'db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['username']) || !isset($data['password'])) {
    echo json_encode(['success' => false, 'message' => 'Username and password are required']);
    exit;
}

$username = trim($data['username']);
$password = $data['password'];

try {
    $stmt = $pdo->prepare("SELECT id, username, password, name FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    $role = 'staff';

    // If not found in users, check students table (using username as roll_number)
    if (!$user) {
        $stmt = $pdo->prepare("SELECT id, roll_number as username, password, name FROM students WHERE roll_number = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        $role = 'student';
    }

    if ($user && password_verify($password, $user['password'])) {
        // Start session or return token (using simple token for this demo)
        $token = bin2hex(random_bytes(16));
        
        echo json_encode([
            'success' => true, 
            'message' => 'Login successful',
            'user' => [
                'id' => $user['id'],
                'username' => $user['username'],
                'name' => $user['name'],
                'role' => $role
            ],
            'token' => $token
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
