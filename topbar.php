<?php
// topbar.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit();
}

// Database connection using centralized config
include_once __DIR__ . '/config/database.php';
// $con is already defined in config/database.php

// Get user role
$stmt = $con->prepare("SELECT * FROM memberregistration WHERE UserName = ?");
$stmt->bind_param("s", $_SESSION["login"]);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name1 = htmlspecialchars($row['FirstName']);
    $name2 = htmlspecialchars($row['LastName']);
    $reg1 = htmlspecialchars($row['RegNo']);
    $role = $row['RoleID'];
    $Dp = $row['ProfilePhoto'];
    $email = htmlspecialchars($row['Email']);
    $whatsappno = htmlspecialchars($row['WhatsAppNo']);

    // Load appropriate menu based on role
    $menu_file = ($role == 1) ? 'admin_menu_items.php' : 'user_menu_items.php';
    $current_page = basename($_SERVER['PHP_SELF']);
    $menu_items = include 'config/' . $menu_file;
    $page_title = $menu_items[$current_page] ?? 'Page Title';
} else {
    header("Location: logout.php");
    exit();
}
$stmt->close();
// $con->close(); // Removed to prevent "mysqli object is already closed" errors in main pages
?>

<link rel="stylesheet" href="css/topbar.css">

<header class="topbar">
    <h1><?php echo htmlspecialchars($page_title); ?></h1>

    <div class="user-details">
        <div class="user">
            <?php if ($role == 1): ?>
                <span class="badge">Admin</span>
            <?php endif; ?>
            <p id="name"><?php echo $name1 . ' ' . $name2; ?></p>
            <p id="reg-no"><?php echo $reg1; ?></p>
            <a class="logout-btn" href="logout.php">Logout</a>
        </div>
        <?php
        $profilePic = (!empty($Dp) && file_exists(__DIR__ . '/ProfilePhoto/' . $Dp))
            ? 'ProfilePhoto/' . htmlspecialchars($Dp)
            : 'https://ui-avatars.com/api/?name=' . urlencode($name1 . ' ' . $name2) . '&background=random&color=fff';
        ?>
        <img src="<?php echo $profilePic; ?>" alt="User Profile Picture">
    </div>
</header>

<style>
    /* Keep your existing styles */
    .badge {
        background: #ff9800;
        color: white;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.8em;
        margin-right: 5px;
    }

    .logout-btn {
        color: rgb(255, 232, 86);
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s;
    }

    .logout-btn:hover {
        color: #ffc107;
    }
</style>