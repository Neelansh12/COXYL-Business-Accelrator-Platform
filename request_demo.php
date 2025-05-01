<?php
// Only allow POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('HTTP/1.0 403 Forbidden');
    exit(json_encode(['status' => 'error', 'message' => 'Access forbidden']));
}

include 'connect.php'; // your database connection file

header('Content-Type: application/json');

// Sanitize inputs
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$company = filter_input(INPUT_POST, 'company', FILTER_SANITIZE_SPECIAL_CHARS);
$companyOption = filter_input(INPUT_POST, 'company_option', FILTER_SANITIZE_SPECIAL_CHARS);

// Validate
if (empty($email) || empty($company)) {
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
    $stmt = $conn->prepare("INSERT INTO demo_requests (email, company, company_option) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $company, $companyOption);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Demo request submitted successfully']);
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
