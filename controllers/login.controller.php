<?php
session_start();
require '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $identifier = trim($_POST['identifier']);
    $password = $_POST['password'];

    // Search user
    $stmt = $conn->prepare("SELECT id, username, password_hash, role FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    // Verify password
    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        header("Location: ../views/dashboard.view.php");
        exit();
    } else {
        // If an error occurs, pop up an alert and redirect
        echo "<script>alert('Invalid username, email, or password.'); window.location.href = '../index.php';</script>";
        exit();
    }
}
?>