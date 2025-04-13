<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /COMP3421/index.php");
    exit();
}
$errors = $_SESSION['errors'] ?? [];
$success = $_SESSION['success'] ?? '';
unset($_SESSION['errors'], $_SESSION['success']);
$post_id = (int)$_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Comment</title>
    <link rel="stylesheet" href="/COMP3421/dashstyle.css">
</head>
<body>
    <div>
        <h1>Add Comment</h1>
        <p>Logged in as <strong><?= htmlspecialchars($_SESSION['role']) ?></strong></p>
        <?php if ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if (isset($errors['content'])): ?>
            <div class="error-message"><?= htmlspecialchars($errors['content']) ?></div>
        <?php endif; ?>
        <form accept-charset="UTF-8" role="form" method="post" action="/COMP3421/controllers/comment.controller.php?id=<?= $post_id ?>" ?>
            <div>
                <label for="content">comment:</label>
                <textarea name="content" id="content" rows="5" cols="50" maxlength="255" required placeholder="Enter your comment (max 255 characters)"></textarea>
            </div>
            <button type="submit" name="add_comment" class="btn btn-primary">Add comment</button>
        </form>
        <a href="/COMP3421/views/dashboard.view.php" class="btn btn-warning">Back to Dashboard</a>
    </div>
</body>
</html>

