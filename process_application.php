<?php
// Prevent direct access
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('HTTP/1.0 403 Forbidden');
    exit(json_encode(['status' => 'error', 'message' => 'Access forbidden']));
}

include 'connect.php';

header('Content-Type: application/json'); // Tell browser we're sending JSON

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$startupName = filter_input(INPUT_POST, 'startupName', FILTER_SANITIZE_SPECIAL_CHARS);

if (empty($name) || empty($email) || empty($startupName)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
    exit();
}

try {
    $stmt = $conn->prepare("INSERT INTO applications (name, email, startup_name) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $startupName);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Application submitted successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
    }
    $stmt->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Server error: ' . $e->getMessage()]);
} finally {
    $conn->close();
}
?>
