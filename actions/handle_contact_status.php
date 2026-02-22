<?php
session_start();
include_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION["login"]) || $_SESSION["role"] != 1) {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['id']) && isset($_POST['done_button'])) {
    $id = $_GET['id'];

    $stmt = $con->prepare("UPDATE contactus SET status = 'Approve' WHERE ID = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../AdminNotification.php?success=Message marked as done.");
    } else {
        header("Location: ../AdminNotification.php?error=Error updating message status.");
    }
    $stmt->close();
} else {
    header("Location: ../AdminNotification.php");
}
?>