<?php
session_start();
include_once __DIR__ . '/../config/database.php';

if (isset($_POST['login'])) {
    $UserName = trim($_POST['userName']);
    $Password = $_POST['password'];

    // Updated with Prepared Statement
    $stmt = $con->prepare("SELECT * FROM memberregistration WHERE UserName=? AND status='Approve'");
    $stmt->bind_param("s", $UserName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($Password, $row['Password'])) {
            $_SESSION["login"] = $row['UserName'];
            $_SESSION["user_id"] = $row['ID'];
            $_SESSION["role"] = $row['RoleID'];

            if ($row['RoleID'] == 1) {
                header('Location: ../AdminDashboard.php');
            } else {
                header('Location: ../userDashboard.php');
            }
            exit();
        } else {
            header('Location: ../index.php?error=Incorrect password');
            exit();
        }
    } else {
        header('Location: ../index.php?error=User not found or not approved');
        exit();
    }
    $stmt->close();
}
?>