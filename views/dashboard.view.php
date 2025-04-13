<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /COMP3421/index.php");
    exit();
}


require '../db_connect.php';


$stmt = $conn->prepare("SELECT id, username, content FROM post ORDER BY id DESC");
$stmt->execute();
$result = $stmt->get_result();
$posts = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="/COMP3421/dashstyle.css">
</head>
<body>

    <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> (Role: <?= htmlspecialchars($_SESSION['role']) ?>)</h1>
    <a href="/COMP3421/controllers/logout.controller.php" class="btn btn-warning">Logout</a>
    <h2>List of Posts</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Post Owner</th>
                <th>Content</th>
                <th>Comment</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($posts as $post): ?>
            <tr>
                <td><?= htmlspecialchars($post['username']) ?></td>
                <td><?= htmlspecialchars($post['content']) ?></td>
                <td><a href="/COMP3421/d_fm?id=<?= $post['id'] ?>" class="btn btn-primary">-Comment?</a></td>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <td><a href="/COMP3421/controllers/post.controller.php?action=delete&id=<?= $post['id'] ?>" class="btn btn-primary">-delete?</a></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="/COMP3421/views/add_post.view.php" class="btn btn-warning">+ Add Post</a>
</body>
</html>