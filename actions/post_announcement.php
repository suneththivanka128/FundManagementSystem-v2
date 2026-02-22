<?php
include __DIR__ . '/../config/database.php';

if (isset($_POST['publish'])) {
    $date = $_POST['date'];
    $message = $_POST['message'];

    if (!empty($message)) {
        $stmt = $con->prepare("INSERT INTO announcement (Date, Message) VALUES (?, ?)");
        $stmt->bind_param("ss", $date, $message);

        if ($stmt->execute()) {
            echo "<script>alert('Announcement published successfully!'); window.location.href='../AdminAnnouncement.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='../AdminAnnouncement.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Message cannot be empty!'); window.location.href='../AdminAnnouncement.php';</script>";
    }
} else {
    header("Location: ../AdminAnnouncement.php");
}
?>