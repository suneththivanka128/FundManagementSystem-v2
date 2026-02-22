<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/Favicon.png">
    <link rel="stylesheet" href="css/AdminNotification.css">
    <title>Member Approvals</title>
</head>

<body>
    <?php
    // Set the current page for active tab highlighting
    $current_page = 'AdminNotification.php';
    include('sidebar.php');
    include('topbar.php');
    ?>

    <main>
        <h1>Member Approval Requests</h1>

        <?php
        include_once __DIR__ . '/config/database.php';
        $sql = "SELECT * FROM memberregistration WHERE status='pending'";
        $result = $con->query($sql);

        if ($result->num_rows > 0): ?>
            <div class="approval-container">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <form method="post" action="actions/handle_member_approval.php?id=<?php echo $row['ID'] ?>"
                        class="approval-card">
                        <h2>Member Registration</h2>
                        <div class="info-grid">
                            <div class="label">First Name:</div>
                            <div class="value"><?php echo htmlspecialchars($row['FirstName']) ?></div>

                            <div class="label">Last Name:</div>
                            <div class="value"><?php echo htmlspecialchars($row['LastName']) ?></div>

                            <div class="label">Registration Number:</div>
                            <div class="value"><?php echo htmlspecialchars($row['RegNo']) ?></div>

                            <div class="label">Email:</div>
                            <div class="value"><?php echo htmlspecialchars($row['Email']) ?></div>

                            <div class="label">NIC Number:</div>
                            <div class="value"><?php echo htmlspecialchars($row['NICNumber']) ?></div>

                            <div class="label">Date of Birth:</div>
                            <div class="value"><?php echo htmlspecialchars($row['DateOfBirth']) ?></div>

                            <div class="label">WhatsApp:</div>
                            <div class="value"><?php echo htmlspecialchars($row['WhatsAppNo']) ?></div>

                            <div class="label">Username:</div>
                            <div class="value"><?php echo htmlspecialchars($row['UserName']) ?></div>
                        </div>
                        <div class="buttons">
                            <input type="submit" name="approve_button" class="button approve-button" value="Approve">
                            <input type="submit" name="reject_button" class="button reject-button" value="Reject">
                        </div>
                    </form>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="no-pending">
                <p>No pending member approvals at this time.</p>
            </div>
        <?php endif; ?>





        <h1>Member Messages</h1>

        <?php
        include_once __DIR__ . '/config/database.php';
        $sql = "SELECT * FROM contactus WHERE status='pending'";
        $result = $con->query($sql);

        if ($result->num_rows > 0): ?>
            <div class="approval-container">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <form method="post" action="actions/handle_contact_status.php?id=<?php echo $row['ID'] ?>"
                        class="approval-card">
                        <h2>Member Messages</h2>
                        <div class="info-grid">
                            <div class="label">Registration Number:</div>
                            <div class="value"><?php echo htmlspecialchars($row['RegNo']) ?></div>

                            <div class="label">Email:</div>
                            <div class="value"><?php echo htmlspecialchars($row['Email']) ?></div>

                            <div class="label">Whatsapp Number:</div>
                            <div class="value"><?php echo htmlspecialchars($row['WhatsAppNo']) ?></div>

                            <div class="label">Subject:</div>
                            <div class="value"><?php echo htmlspecialchars($row['Subject']) ?></div>

                            <div class="label">Message:</div>
                            <div class="value"><?php echo htmlspecialchars($row['Message']) ?></div>

                        </div>
                        <div class="buttons">
                            <input type="submit" name="done_button" class="button approve-button" value="Done">
                            <!-- <input type="submit" name="reject_button" class="button reject-button" value="Reject">  -->
                        </div>
                    </form>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="no-pending">
                <p>No pending messages at this time.</p>
            </div>
        <?php endif; ?>




    </main>
</body>

</html>