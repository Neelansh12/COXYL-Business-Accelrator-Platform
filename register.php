<?php
include 'connect.php'; // this will connect to your database

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Collect user input
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password

    // Check if email already exists
    $checkEmail = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        // If email already exists
        echo "<script>alert('Email already registered. Please login!'); window.location.href='login.html';</script>";
    } else {
        // Insert user into database
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, dob, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $fullname, $email, $dob, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Please login.'); window.location.href='login.html';</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.'); window.location.href='login.html';</script>";
        }
        $stmt->close();
    }
    $checkEmail->close();
    $conn->close();
} else {
    // If someone tries to access register.php without POST method
    header("Location: login.html");
    exit();
}
?>
