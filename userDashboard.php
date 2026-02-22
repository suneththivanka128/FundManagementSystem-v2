<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit();
}

// Check if admin is trying to access user dashboard
if (isset($_SESSION["role"]) && $_SESSION["role"] == 1) {
    header("Location: AdminDashboard.php");
    exit();
}

$login = $_SESSION["login"];
include_once __DIR__ . '/config/database.php';

// Get user details using prepared statement
$user_sql = "SELECT * FROM memberregistration WHERE UserName = ?";
$stmt = $con->prepare($user_sql);
$stmt->bind_param("s", $login);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();
$stmt->close();

if (!$user) {
    // If user not found, log them out
    header("Location: logout.php");
    exit();
}

// Get all payment history
$payment_sql = "SELECT * FROM add_payment WHERE RegistrationNo = ? ORDER BY PaymentDate DESC";
$stmt = $con->prepare($payment_sql);
$stmt->bind_param("s", $user['RegNo']);
$stmt->execute();
$payment_result = $stmt->get_result();

// Get payment totals by year
$yearly_totals_sql = "SELECT ForYear, SUM(Amount) as total 
                     FROM add_payment 
                     WHERE RegistrationNo = ? 
                     GROUP BY ForYear 
                     ORDER BY ForYear DESC";
$stmt = $con->prepare($yearly_totals_sql);
$stmt->bind_param("s", $user['RegNo']);
$stmt->execute();
$yearly_totals_result = $stmt->get_result();

// Get complete fund summary
include 'api/get_complete_fund_summery.php';

// Prepare data for charts
$yearly_data = [];
while ($row = $yearly_totals_result->fetch_assoc()) {
    $yearly_data[$row['ForYear']] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/Favicon.png">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/userDashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php include('usersidebar.php'); ?>
    <?php include('topbar.php'); ?>

    <main>
        <div class="container">
            <div class="dashboard-header">
                <h2>Welcome, <?php echo htmlspecialchars($user['FirstName'] . ' ' . $user['LastName']); ?></h2>
            </div>

            <!-- Complete Fund Summary -->
            <div class="fund-summary-section">
                <h3>Fund Summary</h3>
                <div class="fund-summary-grid">
                    <div class="fund-card total-collected">
                        <div class="fund-icon">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div class="fund-details">
                            <h4>Total Collected</h4>
                            <p>Rs. <?php echo number_format($total_collected, 2); ?></p>
                            <span class="fund-meta">From <?php echo $total_payments; ?> payments</span>
                        </div>
                    </div>

                    <div class="fund-card total-expenses">
                        <div class="fund-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div class="fund-details">
                            <h4>Total Expenses</h4>
                            <p>Rs. <?php echo number_format($total_expenses, 2); ?></p>
                            <span class="fund-meta">All fund expenditures</span>
                        </div>
                    </div>

                    <div class="fund-card current-balance">
                        <div class="fund-icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="fund-details">
                            <h4>Current Balance</h4>
                            <p>Rs. <?php echo number_format($current_balance, 2); ?></p>
                            <span class="fund-meta">Available funds</span>
                        </div>
                    </div>

                    <div class="fund-card total-members">
                        <div class="fund-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="fund-details">
                            <h4>Total Members</h4>
                            <p><?php echo $total_members; ?></p>
                            <span class="fund-meta">Active in system</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Your Payment Summary -->
            <div class="payment-summary-section">
                <h3>Your Contribution Summary</h3>
                <div class="summary-container">
                    <div class="chart-container">
                        <canvas id="yearlyChart"></canvas>
                    </div>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Year</th>
                                    <th>Your Contribution</th>
                                    <th>% of Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $user_total = array_sum($yearly_data);
                                foreach ($yearly_data as $year => $amount):
                                    $percentage = $total_collected > 0 ? ($amount / $total_collected) * 100 : 0;
                                    ?>
                                        <tr>
                                        <td><?php echo htmlspecialchars($year); ?></td>
                                        <td>Rs. <?php echo number_format($amount, 2); ?></td>
                                        <td><?php echo number_format($percentage, 2); ?>%</td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="total-row">
                                    <td><strong>Total</strong></td>
                                    <td><strong>Rs. <?php echo number_format($user_total, 2); ?></strong></td>
                                    <td><strong><?php echo $total_collected > 0 ? number_format(($user_total / $total_collected) * 100, 2) : '0.00'; ?>%</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Payment History -->
            <div class="payment-history">
                <h3>Your Payment History</h3>
                <?php if ($payment_result->num_rows > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Payment ID</th>
                                <th>Date</th>
                                <th>For Month</th>
                                <th>For Year</th>
                                <th>Amount (Rs.)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $payment_result->data_seek(0);
                            while ($payment = $payment_result->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($payment['PaymentID']); ?></td>
                                    <td><?php echo htmlspecialchars(date('d M Y', strtotime($payment['PaymentDate']))); ?></td>
                                    <td><?php echo htmlspecialchars($payment['ForMonth']); ?></td>
                                    <td><?php echo htmlspecialchars($payment['ForYear']); ?></td>
                                    <td><?php echo number_format($payment['Amount'], 2); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No payment history found.</p>
                <?php endif; ?>
            </div>
        </div>

        <script>
            // Yearly Chart
            const yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
            const yearlyChart = new Chart(yearlyCtx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode(array_keys($yearly_data)); ?>,
                    datasets: [{
                        label: 'Your Contributions (Rs.)',
                        data: <?php echo json_encode(array_values($yearly_data)); ?>,
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return 'Rs. ' + context.raw.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value) {
                                    return 'Rs. ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        </script>
    </main>
</body>

</html>