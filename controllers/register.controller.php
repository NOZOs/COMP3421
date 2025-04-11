<?php
session_start();
require '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Validate input
    $error = null;
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    }

    // Check if username or email address is duplicated
    if (!$error) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Username or email already exists.";
        }
        $stmt->close();
    }

    // Insert into database
    if (!$error) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $password_hash, $role);
        if (!$stmt->execute()) {
            $error = "Registration failed. Please try again.";
        }
        $stmt->close();
    }

    // output alert and redirect
    if ($error) {
        // pop up error alert if error occur
        echo "<script>alert('" . addslashes($error) . "'); window.location.href = '../index.php';</script>";
    } else {
        echo "<script>alert('Registration successful!'); window.location.href = '../index.php';</script>";
    }
    exit(); 
}
?>