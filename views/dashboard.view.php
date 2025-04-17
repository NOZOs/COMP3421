<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}


require '../db_connect.php';
require '../config.php';


$stmt = $conn->prepare("
    SELECT p.id AS post_id, p.username AS post_username, p.content AS post_content, 
           c.id AS comment_id, c.username AS comment_username, c.content AS comment_content
    FROM post p
    LEFT JOIN comment c ON p.id = c.post_id
    ORDER BY p.id DESC, c.id ASC
");
$stmt->execute();
$result = $stmt->get_result();
$posts = [];
while ($row = $result->fetch_assoc()) {
    $post_id = $row['post_id'];
    $posts[$post_id]['post_username'] = $row['post_username'];
    $posts[$post_id]['post_content'] = $row['post_content'];
    if ($row['comment_id']) {
        $posts[$post_id]['comments'][] = [
            'id' => $row['comment_id'],
            'username' => $row['comment_username'],
            'content' => $row['comment_content'],
        ];
    }
}
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="../dashstyle.css">
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-QLF9JNV97F"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
         function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-QLF9JNV97F');
    </script>
</head>
<body>

    <h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> (Role: <?= htmlspecialchars($_SESSION['role']) ?>)</h1>
    <a href="../controllers/logout.controller.php" class="btn btn-warning">Logout</a>
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
        <?php foreach($posts as $post_id => $post): ?>
            <tr>
                <td><?= htmlspecialchars($post['post_username']) ?></td>
                <td><?= htmlspecialchars($post['post_content']) ?></td>
                <td>
                    <a href="../views/add_comment.view.php?id=<?= $post_id ?>" class="btn btn-warning">+ Add Comment</a>
                    <ul>
                        <?php if (!empty($post['comments'])): ?>
                            <?php foreach ($post['comments'] as $comment): ?>
                                <li>
                                    <strong><?= htmlspecialchars($comment['username']) ?>:</strong> <?= htmlspecialchars($comment['content']) ?>
                                    <?php if ($_SESSION['role'] === 'admin'): ?>
                                        <a href="../controllers/comment.controller.php?action=delete&id=<?= $comment['id'] ?>" class="btn btn-warning">Delete comment</a>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </td>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <td><a href="../controllers/post.controller.php?action=delete&id=<?= $post_id ?>" class="btn btn-primary">Delete post</a></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <a href="../views/add_post.view.php" class="btn btn-warning">+ Add Post</a>
</body>
</html>