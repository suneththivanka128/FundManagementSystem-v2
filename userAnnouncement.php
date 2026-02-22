<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/Favicon.png">
    <link rel="stylesheet" href="css/AdminAnnouncement.css">
    <title>Announcement</title>
</head>

<body>
    <?php include('usersidebar.php'); ?>
    <?php include('topbar.php'); ?>

    <main>
        <div class="container">
            <div class="announcements">

                <!-- <div id="datetime" ></div>
            <script src="js/DateTime.js" type="text/javascript"></script> -->

                <?php

                include_once __DIR__ . '/config/database.php';
                $sql = "SELECT * FROM announcement ";
                $result = $con->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $AMessage = $row['Message'];

                        echo "";

                        ?>

                        <details class="announcement">
                            <p><?php echo $AMessage ?></p>
                        </details>

                    <?php }
                } ?>


            </div>
        </div>
    </main>




</body>

</html>