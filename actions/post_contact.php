<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION["login"])) {
    header("Location: ../index.php");
    exit();
}

if (isset($_POST['submit'])) {
    $userName = $_SESSION["login"];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Get member details for the contact record
    $stmt = $con->prepare("SELECT RegNo, Email, WhatsAppNo FROM memberregistration WHERE UserName = ?");
    $stmt->bind_param("s", $userName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $regNo = $row['RegNo'];
        $email = $row['Email'];
        $whatsappNo = $row['WhatsAppNo'];

        $insertStmt = $con->prepare("INSERT INTO contactus (RegNo, Email, WhatsAppNo, Subject, Message, status) VALUES (?, ?, ?, ?, ?, 'pending')");
        $insertStmt->bind_param("sssss", $regNo, $email, $whatsappNo, $subject, $message);

        if ($insertStmt->execute()) {
            echo "<script>alert('Your message has been sent successfully!'); window.location.href='../userContactUs.php';</script>";
        } else {
            echo "<script>alert('Error sending message: " . $insertStmt->error . "'); window.location.href='../userContactUs.php';</script>";
        }
        $insertStmt->close();
    } else {
        echo "<script>alert('Error: User details not found.'); window.location.href='../userContactUs.php';</script>";
    }
    $stmt->close();
} else {
    header("Location: ../userContactUs.php");
}
?>