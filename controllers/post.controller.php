<?php
session_start();
require '../db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_post'])) {
    $content = trim($_POST['content']);
    $errors = [];

    if (empty($content)) {
        $errors['content'] = "Content is required.";
    } elseif (strlen($content) > 255) {
        $errors['content'] = "Content must not exceed 255 characters.";
    }

    if (empty($errors)) {
        $username = $_SESSION['username'];
        $stmt = $conn->prepare("INSERT INTO post (username, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $content);
        if ($stmt->execute()) {
            $stmt->close();

            echo "<script>alert('Post added successfully!'); window.location.href = '../views/dashboard.view.php';</script>";
            exit();
        } else {
            $errors['content'] = "Failed to add post. Please try again.";
            $stmt->close();
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../views/add_post.view.php");
        exit();
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $post_id = (int)$_GET['id'];;
    $username = $_SESSION['username'];

    $stmt = $conn->prepare("SELECT username FROM post WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
    $stmt->close();

    if ($post) {
            $stmt = $conn->prepare("DELETE FROM post WHERE id = ?");
            $stmt->bind_param("i", $post_id);
            if ($stmt->execute()) {
                $stmt->close();
                echo "<script>alert('Post deleted successfully!'); window.location.href = '../views/dashboard.view.php';</script>";
                exit();
            } else {
                $stmt->close();
                echo "<script>alert('Failed to delete post. Please try again.'); window.location.href = '../views/dashboard.view.php';</script>";
                exit();
            }
        } 
    }
?>

