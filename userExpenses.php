<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses</title>
    <link rel="icon" type="image/x-icon" href="images/Favicon.png">
    <link rel="stylesheet" href="css/AdminExpenses.css">
</head>

<body>
    <?php include('usersidebar.php'); ?>
    <?php include('topbar.php'); ?>

    <main>
        <section class="history-section">
            <h2 class="history-header">Expenses History</h2>
            <table id="historyTable" class="history-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Entered by</th>
                        <th>Amount</th>
                        <th>Details</th>
                        <th>Responser</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include_once __DIR__ . '/config/database.php';

                    $sql = "SELECT * FROM expenses ORDER BY Date DESC, Time DESC";
                    $result = $con->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>" . date("d M Y", strtotime($row['Date'])) . "</td>
                                <td>" . htmlspecialchars($row['DataAdder']) . "</td>
                                <td>Rs." . number_format($row['Amount'], 2) . "</td>
                                <td>" . htmlspecialchars($row['Description']) . "</td>
                                <td>" . htmlspecialchars($row['Responser']) . "</td>
                              </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No expenses found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>