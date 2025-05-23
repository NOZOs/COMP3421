<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /COMP3421/index.php");
    exit();
}
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
unset($_SESSION['errors'], $_SESSION['success']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Post</title>
    <link rel="stylesheet" href="/COMP3421/dashstyle.css">
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-QLF9JNV97F"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
         function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-QLF9JNV97F');
    </script>
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
        <form accept-charset="UTF-8" role="form" method="post" action="/COMP3421/controllers/post.controller.php">
            <div>
                <label for="content">Post Content:</label>
                <textarea name="content" id="content" rows="5" cols="50" maxlength="255" required placeholder="Enter your post content (max 255 characters)"></textarea>
            </div>
            <button type="submit" name="add_post" class="btn btn-primary" onclick="gtag('event', 'New post');">Add Post</button>
        </form>
        <a href="/COMP3421/views/dashboard.view.php" class="btn btn-warning">Back to Dashboard</a>
    </div>
</body>
</html>