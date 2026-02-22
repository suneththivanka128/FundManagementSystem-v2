<?php
session_start();
include_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION["login"]) || $_SESSION["role"] != 1) {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if (isset($_POST['approve_button'])) {
        $stmt = $con->prepare("UPDATE memberregistration SET status = 'Approve' WHERE ID = ?");
        $stmt->bind_param("i", $id);
        $status = "approved";
    } elseif (isset($_POST['reject_button'])) {
        $stmt = $con->prepare("UPDATE memberregistration SET status = 'Reject' WHERE ID = ?");
        $stmt->bind_param("i", $id);
        $status = "rejected";
    } else {
        header("Location: ../AdminNotification.php");
        exit();
    }

    if ($stmt->execute()) {
        header("Location: ../AdminNotification.php?success=Member $status successfully.");
    } else {
        header("Location: ../AdminNotification.php?error=Error updating member status.");
    }
    $stmt->close();
} else {
    header("Location: ../AdminNotification.php");
}
?>