<?php
session_start();
require '../db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /COMP3421/index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_comment'])) {

    $content = trim($_POST['content']);
    $errors = [];

    if (empty($content)) {
        $errors['content'] = "Content is required.";
    } elseif (strlen($content) > 255) {
        $errors['content'] = "Content must not exceed 255 characters.";
    }

    if (empty($errors)) {
        $username = $_SESSION['username'];
        $post_id = (int)$_GET['id'];
        $stmt = $conn->prepare("INSERT INTO comment (post_id, username, content) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $post_id, $username, $content);
        if ($stmt->execute()) {
            $stmt->close();

            echo "<script>alert('comment added successfully!'); window.location.href = '../views/dashboard.view.php';</script>";
            exit();
        } else {
            $errors['content'] = "Failed to add comment. Please try again.";
            $stmt->close();
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: ../views/add_comment.view.php?id=" . $_GET['id']);
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
            $stmt = $conn->prepare("DELETE FROM comment WHERE id = ?");
            $stmt->bind_param("i", $post_id);
            if ($stmt->execute()) {
                $stmt->close();
                echo "<script>alert('comment deleted successfully!'); window.location.href = '../views/dashboard.view.php';</script>";
                exit();
            } else {
                $stmt->close();
                echo "<script>alert('Failed to delete comment. Please try again.'); window.location.href = '../views/dashboard.view.php';</script>";
                exit();
            }
        } 
    }
?>

