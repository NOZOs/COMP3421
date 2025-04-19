<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

require '../db_connect.php';
require '../config.php';

$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
unset($_SESSION['errors'], $_SESSION['success']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Post</title>
    <link rel="stylesheet" href="../dashstyle.css">
</head>
<body>
    <div>
        <h1>Blog</h1>
        <p class="lead">Add POST</p>
        <p>Logged in as <strong><?= htmlspecialchars($_SESSION['role']) ?></strong></p>
        <?php if ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if (isset($errors['content'])): ?>
            <div class="error-message"><?= htmlspecialchars($errors['content']) ?></div>
        <?php endif; ?>
        <form accept-charset="UTF-8" role="form" method="post" action="../controllers/post.controller.php">
            <div>
                <label for="content">Post Content:</label>
                <textarea name="content" id="content" rows="5" cols="50" maxlength="255" required placeholder="Enter your post content (max 255 characters)"></textarea>
            </div>
            <button type="submit" name="add_post" class="btn btn-primary">Add Post</button>
        </form>
        <a href="../views/dashboard.view.php" class="btn btn-warning">Back to Dashboard</a>
    </div>
</body>
</html>