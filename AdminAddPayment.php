<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/Favicon.png">
    <link rel="stylesheet" href="css/addPayment.css">
    <title>Add Payment</title>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <style>
        .button2 {
            background-color: rgb(255, 0, 0);
            color: white;
            padding: 6px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }


        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-dialog {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            max-width: 90%;
            width: 400px;
            text-align: center;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .modal-overlay.active .modal-dialog {
            transform: scale(1);
        }

        /* --- Specific styles for the Submit Confirmation Dialog Buttons --- */

        #confirmSubmit {
            background-color: #45a049;
            color: white;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        #confirmSubmit:hover {
            background-color: #3e8e41;
            transform: scale(1.05);
        }


        #cancelSubmit {
            background-color: #d1d5db;
            color: #4b5563;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        #cancelSubmit:hover {
            background-color: #9ca3af;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <?php include('sidebar.php'); ?>
    <?php include('topbar.php'); ?>



    <main>
        <section class="payment-section">
            <?php
            $MemberName = "";
            $MemberRegNo = "";

            ?>

            <?php
            $RegNo = "";
            include_once __DIR__ . '/config/database.php';

            if (isset($_POST['check'])) {
                $RegNo = $_POST['RegNo'];

                $stmt = $con->prepare("SELECT * FROM memberregistration WHERE RegNo=?");
                $stmt->bind_param("s", $RegNo);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $MemberName = $row['FirstName'];
                        $MemberRegNo = $row['RegNo'];
                        $dp = $row['ProfilePhoto'];
                    }
                }
                $stmt->close();
            }

            if (isset($_POST['delete'])) {
                $PID = $_POST['pid'];
                $stmt = $con->prepare("UPDATE add_payment SET Status ='deleted' WHERE PaymentID=?");
                $stmt->bind_param("i", $PID);
                $stmt->execute();
                $stmt->close();

                echo "<script>window.location.href = 'AdminAddPayment.php';</script>";
            }

            if (isset($_POST['submit'])) {
                $RegNo = $_POST['RegNo'];
                $PaymentDate = $_POST['PaymentDate'];
                $Year = $_POST['year'];
                $Month = $_POST['month'];
                $Amount = $_POST['amount'];

                $stmt = $con->prepare("INSERT INTO add_payment(RegistrationNo, PaymentDate, ForYear, ForMonth, Amount) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssd", $RegNo, $PaymentDate, $Year, $Month, $Amount);
                $stmt->execute();
                $stmt->close();
            }
            ?>

            <form id="paymentForm" method="post" action="#">
                <label for="reg-no">Registration No:</label>
                <input type="text" id="reg-no" name="RegNo" value="<?php echo $MemberRegNo ?>" required>
                <input style="display: none;" type="text" id="PaymentDate" name="PaymentDate"
                    value="<?php echo date('Y-m-d'); ?>">
                <button type="submit" aria-label="Search" name="check">Check</button><br>

                <label for="year-input">Month:</label>
                <select name="year" id="year">
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                </select>

                <select name="month" id="month">
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="Aprial">Aprial</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                </select>

                <label for="price">Amount:</label>
                <input type="number" id="amount" name="amount">

                <button type="button" id="submitButton">Submit</button>

                <div id="submitConfirmationDialog" class="modal-overlay">
                    <div class="modal-dialog">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Confirm Submission</h2>
                        <p class="text-gray-700 mb-6">Are you sure you want to add this payment?</p>
                        <div class="flex justify-center space-x-4">
                            <button name="submit" id="confirmSubmit"
                                class="text-white font-semibold py-2 px-5 rounded-md shadow-sm transition duration-300 ease-in-out transform hover:scale-105">
                                Confirm
                            </button>
                            <button id="cancelSubmit"
                                class="font-semibold py-2 px-5 rounded-md shadow-sm transition duration-300 ease-in-out transform hover:scale-105">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </section>

        <section class="Group1">
            <section class="Payeer-section">
                <?php
                $payeePic = (!empty($dp) && file_exists(__DIR__ . '/ProfilePhoto/' . $dp))
                    ? 'ProfilePhoto/' . htmlspecialchars($dp)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($MemberName) . '&background=random&color=fff';
                ?>
                <img src="<?php echo $payeePic; ?>" alt="Payeer image">
                <section class="Group1-1">
                    <h4>Name: <?php echo $MemberName ?></h4>
                    <h4>Registration No: <?php echo $MemberRegNo ?></h4>
                </section>
            </section>


            <section class="payment-history">
                <h2>Payment History</h2>
                <div class="payment-history-table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Payment ID</th>
                                <th>Year</th>
                                <th>Month</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $Total = 0;

                            include_once __DIR__ . '/config/database.php';

                            if ($RegNo == "") {
                                $sql = "SELECT * FROM add_payment";
                            } else {
                                $sql = "SELECT * FROM add_payment WHERE RegistrationNo ='$RegNo'";
                            }


                            $result = $con->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $PID = $row['PaymentID'];
                                    $PYear = $row['ForYear'];
                                    $PMonth = $row['ForMonth'];
                                    $PAmount = $row['Amount'];
                                    $PDate = $row['PaymentDate'];
                                    $PStatus = $row['Status'];

                                    if ($PStatus == "active") {
                                        $Total = $Total + (int) $PAmount;

                                        ?>
                                        <tr>
                                            <td><?php echo $PID ?></td>
                                            <td><?php echo $PYear ?></td>
                                            <td><?php echo $PMonth ?></td>
                                            <td><?php echo $PAmount ?></td>
                                            <td><?php echo $PDate ?></td>
                                            <td>
                                                <button class="button2 delete-trigger-button" type="button" name="delete"
                                                    data-pid="<?php echo $PID; ?>">Delete</button>
                                            </td>
                                        </tr>
                                    <?php }
                                }
                            }

                            // echo $Total;
                            ?>


                        </tbody>
                    </table>
                </div>
            </section>
        </section>

        <div id="confirmationDialog" class="modal-overlay">
            <div class="modal-dialog">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Confirm Deletion</h2>
                <p class="text-gray-700 mb-6">Are you sure you want to delete this item? This action cannot be undone.
                </p>
                <div class="flex justify-center space-x-4">
                    <button id="confirmDelete"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-5 rounded-md shadow-sm transition duration-300 ease-in-out transform hover:scale-105">
                        Confirm
                    </button>
                    <button id="cancelDelete"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-5 rounded-md shadow-sm transition duration-300 ease-in-out transform hover:scale-105">
                        Cancel
                    </button>
                </div>
            </div>
        </div>


    </main>

    <script>
        // Get references to the elements for DELETE confirmation
        const confirmationDialog = document.getElementById('confirmationDialog');
        const confirmDeleteButton = document.getElementById('confirmDelete');
        const cancelDeleteButton = document.getElementById('cancelDelete');
        const deleteTriggerButtons = document.querySelectorAll('.delete-trigger-button'); // Select all delete buttons

        let currentPidToDelete = null; // Variable to store the Payment ID to be deleted

        /**
         * Shows a confirmation dialog by adding the 'active' class.
         * @param {HTMLElement} dialogElement The dialog element to show.
         */
        function showDialog(dialogElement) {
            dialogElement.classList.add('active');
        }

        /**
         * Hides a confirmation dialog by removing the 'active' class.
         * @param {HTMLElement} dialogElement The dialog element to hide.
         */
        function hideDialog(dialogElement) {
            dialogElement.classList.remove('active');
            currentPidToDelete = null; // Clear the stored PID when delete dialog is hidden
        }

        /**
         * Handles the actual deletion logic by submitting a hidden form.
         */
        function performDeletion() {
            if (currentPidToDelete) {
                // Create a temporary form to submit the PID to the PHP script
                const tempForm = document.createElement('form');
                tempForm.method = 'post';
                tempForm.action = '#'; // Or the actual PHP file path if different

                const pidInput = document.createElement('input');
                pidInput.type = 'hidden';
                pidInput.name = 'pid';
                pidInput.value = currentPidToDelete;
                tempForm.appendChild(pidInput);

                const deleteInput = document.createElement('input');
                deleteInput.type = 'hidden';
                deleteInput.name = 'delete'; // This will trigger the 'isset($_POST['delete'])' in PHP
                deleteInput.value = 'true';
                tempForm.appendChild(deleteInput);

                document.body.appendChild(tempForm); // Append to body to submit
                tempForm.submit(); // Submit the form
                document.body.removeChild(tempForm); // Clean up the form after submission
            }
            hideDialog(confirmationDialog); // Hide the delete dialog after initiating deletion
        }

        // Event Listeners for each delete button in the table
        deleteTriggerButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                // Get the Payment ID from the data-pid attribute of the clicked button
                currentPidToDelete = event.target.dataset.pid;
                showDialog(confirmationDialog);
            });
        });

        // Event Listeners for the DELETE dialog buttons
        confirmDeleteButton.addEventListener('click', performDeletion);
        cancelDeleteButton.addEventListener('click', () => hideDialog(confirmationDialog));

        // Optional: Close DELETE dialog if clicking outside of it (on the overlay)
        confirmationDialog.addEventListener('click', (event) => {
            if (event.target === confirmationDialog) {
                hideDialog(confirmationDialog);
            }
        });

        // --- New code for SUBMIT confirmation dialog ---

        // Get references to the elements for SUBMIT confirmation
        const submitButton = document.getElementById('submitButton');
        const submitConfirmationDialog = document.getElementById('submitConfirmationDialog');
        const confirmSubmitButton = document.getElementById('confirmSubmit');
        const cancelSubmitButton = document.getElementById('cancelSubmit');
        const paymentForm = document.getElementById('paymentForm');

        // Event Listener for the Submit button
        submitButton.addEventListener('click', (event) => {
            // Prevent default form submission to show the dialog first
            event.preventDefault();
            // Check form validity before showing the modal
            if (paymentForm.checkValidity()) {
                showDialog(submitConfirmationDialog);
            } else {
                paymentForm.reportValidity(); // Show native browser validation messages
            }
        });

        // Event Listener for the CONFIRM button in the submit dialog
        confirmSubmitButton.addEventListener('click', () => {
            // This is the key change: Submit the form when confirmed
            paymentForm.submit();
            hideDialog(submitConfirmationDialog); // Hide the dialog
        });

        // Event Listener for the CANCEL button in the submit dialog
        cancelSubmitButton.addEventListener('click', () => hideDialog(submitConfirmationDialog));

        // Optional: Close SUBMIT dialog if clicking outside of it (on the overlay)
        submitConfirmationDialog.addEventListener('click', (event) => {
            if (event.target === submitConfirmationDialog) {
                hideDialog(submitConfirmationDialog);
            }
        });
    </script>
</body>

</html>