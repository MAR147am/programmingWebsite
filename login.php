<?php
session_start();

$conn = new mysqli("localhost", "root", "root", "ProgrammingCoursesDB");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, name, password FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['name'];
            
            echo '<script>
                alert("Login successful!");
                window.location.href = "dashboard.html";
            </script>';
            exit;
        } else {
            echo '<script>
                alert("Wrong password!");
                window.location.href = "login.html";
            </script>';
            exit;
        }
    } else {
        echo '<script>
            alert("Email not registered!");
            window.location.href = "login.html";
        </script>';
        exit;
    }
    
    $stmt->close();
}

$conn->close();
?>
