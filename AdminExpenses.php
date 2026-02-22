<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses</title>
    <link rel="icon" type="image/x-icon" href="images/Favicon.png">
    <link rel="stylesheet" href="css/AdminExpenses.css">
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .modal-buttons button {
            margin: 10px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .cancel-btn {
            background-color: red;
            color: white;
        }
    </style>
</head>

<body>
    <?php include('sidebar.php'); ?>
    <?php include('topbar.php'); ?>

    <?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Database connection
    include_once __DIR__ . '/config/database.php';

    // Get user role
    $stmt = $con->prepare("SELECT * FROM memberregistration WHERE UserName = ?");
    $stmt->bind_param("s", $_SESSION["login"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name1 = htmlspecialchars($row['FirstName']);
        $name2 = htmlspecialchars($row['LastName']);

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
    // $con->close();
    ?>



    <main>
        <section class="input-section">
            <h2>Add Expense</h2>
            <form method="post" action="AdminExpenses.php" id="expenseForm">
                <div class="form-group">
                    <label for="dataAdder">Entered By</label>
                    <select style="display: none;" id="dataAdder" name="adder" required>
                        <option value="<?php echo $name1 ?>"></option>
                    </select>
                </div>
                <input type="hidden" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                <input type="hidden" name="time" value="<?php echo date('H:i:s'); ?>" required>

                <div class="form-group">
                    <!-- <label for="category">Category</label> -->
                    <select id="category" name="category" required>
                        <option value="<?php echo $MemberRegNo ?>">Select Category</option>
                        <option>Funeral</option>
                        <option>Special Event</option>
                        <option>Birthday</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="expenseAmount">Expenses Amount</label>
                    <input type="number" id="expenseAmount" name="amount" placeholder="Enter amount" required>
                </div>
                <div class="form-group">
                    <label for="details">Details</label>
                    <textarea id="details" name="details" placeholder="Enter details" required></textarea>
                </div>
                <div class="form-group">
                    <label for="responser">Response By</label>
                    <input type="text" id="responser" name="responser" placeholder="Responder Name" required>
                </div>

                <button type="button" id="openConfirmModalBtn">Submit</button>
                <button type="submit" id="submitFormBtn" name="pay" style="display: none;"></button>
            </form>
        </section>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay'])) {
            include_once __DIR__ . '/config/database.php';

            $Date = $_POST['date'];
            $Time = $_POST['time'];
            $Category = $_POST['category'];
            $DataAdder = $_POST['adder'];
            $Amount = $_POST['amount'];
            $Description = $_POST['details'];
            $Responser = $_POST['responser'];

            $stmt = $con->prepare("INSERT INTO expenses (Date, Time, Category, DataAdder, Amount, Description, Responser) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssiss", $Date, $Time, $Category, $DataAdder, $Amount, $Description, $Responser);

            if ($stmt->execute()) {
                echo "<script>alert('Expense added successfully!'); window.location.href='AdminExpenses.php';</script>";
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }

            $stmt->close();
            // mysqli_close($con);
        }
        ?>

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

                    // mysqli_close($con);
                    ?>
                </tbody>
            </table>
        </section>

        <div id="confirmationModal" class="modal">
            <div class="modal-content">
                <h3>Confirm Expense Submission</h3>
                <p>Are you sure you want to record this expense?</p>
                <div class="modal-buttons">
                    <button id="confirmBtn">Confirm</button>
                    <button id="cancelBtn" class="cancel-btn">Cancel</button>
                </div>
            </div>
        </div>

        <script>
            const modal = document.getElementById("confirmationModal");
            const openModalBtn = document.getElementById("openConfirmModalBtn");
            const confirmBtn = document.getElementById("confirmBtn");
            const cancelBtn = document.getElementById("cancelBtn");
            const expenseForm = document.getElementById("expenseForm");
            const submitFormBtn = document.getElementById("submitFormBtn");

            openModalBtn.onclick = function () {
                if (expenseForm.checkValidity()) {
                    modal.style.display = "flex";
                } else {
                    expenseForm.reportValidity();
                }
            };

            confirmBtn.onclick = function () {
                modal.style.display = "none";
                submitFormBtn.click();
            };

            cancelBtn.onclick = function () {
                modal.style.display = "none";
            };

            window.onclick = function (event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            };
        </script>
    </main>
</body>

</html>