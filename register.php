<?php

// Database connection
$conn = new mysqli("localhost", "root", "root", "ProgrammingCoursesDB");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// When form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    
    // 🔒 تشفير الباسوورد قبل الحفظ
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $checkStmt = $conn->prepare("SELECT user_id FROM Users WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        echo '<script>alert("⚠️ Email already registered!"); window.location.href="login.html";</script>';
        $checkStmt->close();
        $conn->close();
        exit;
    }
    $checkStmt->close();

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO Users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        echo '<script>alert("✅ Registered successfully!"); window.location.href="login.html";</script>';
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
?>
