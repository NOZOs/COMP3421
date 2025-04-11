<?php
// views/dashboard.view.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /3421/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="/3421/style.css">
</head>
<body>
    <h1>Welcome, <?= $_SESSION['username'] ?> (Role: <?= $_SESSION['role'] ?>)</h1>
    <!--Logout -->
    <a href="/3421/controllers/logout.controller.php">Logout</a>
</body>
</html>