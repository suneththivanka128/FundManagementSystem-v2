<?php
session_start();
include_once __DIR__ . '/../config/database.php';

if (isset($_POST['memberregistration'])) {
    $FirstName = $_POST['firstName'];
    $LastName = $_POST['lastName'];
    $RegNo = $_POST['regNo'];
    $Email = $_POST['email'];
    $Nic = $_POST['nic'];
    $DateOfBirth = $_POST['dateofbirth'];
    $WhatsappNo = $_POST['whatsappNo'];
    $UserName = $_POST['userName'];
    $Password = $_POST['password'];
    $PasswordCom = $_POST['passwordCom'];

    if ($Password === $PasswordCom) {
        $fileName = null;

        // Handle Profile Photo Upload if provided
        if (isset($_FILES["profilePhoto"]) && $_FILES["profilePhoto"]["error"] === 0) {
            $targetDir = "../ProfilePhoto/";
            $fileName = time() . "_" . basename($_FILES["profilePhoto"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

            $allowedTypes = array('jpg', 'png', 'jpeg');
            if (in_array($fileType, $allowedTypes) && $_FILES["profilePhoto"]["size"] < 5000000) {
                if (!move_uploaded_file($_FILES["profilePhoto"]["tmp_name"], $targetFilePath)) {
                    header("Location: ../register.php?error=Failed to upload image.");
                    exit();
                }
            } else {
                header("Location: ../register.php?error=Invalid file format or size too large.");
                exit();
            }
        }

        $Hash = password_hash($Password, PASSWORD_DEFAULT);

        $stmt = $con->prepare("INSERT INTO memberregistration(FirstName, LastName, RegNo, Email, NICNumber, DateOfBirth, WhatsAppNo, UserName, Password, ProfilePhoto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $FirstName, $LastName, $RegNo, $Email, $Nic, $DateOfBirth, $WhatsappNo, $UserName, $Hash, $fileName);

        if ($stmt->execute()) {
            header("Location: ../index.php?success=Registration successful. Please wait for admin approval.");
            exit();
        } else {
            header("Location: ../register.php?error=Database error: Registration failed.");
            exit();
        }
    } else {
        header("Location: ../register.php?error=Passwords do not match.");
        exit();
    }
}
?>