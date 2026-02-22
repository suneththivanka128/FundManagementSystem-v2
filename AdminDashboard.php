<?php
session_start();

// Check if user is logged in and is admin
if (!isset($_SESSION["login"]) || $_SESSION["role"] != 1) {
  header("Location: index.php");
  exit();
}

include('api/get_complete_fund_summery.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="images/Favicon.png">
  <link rel="stylesheet" href="css/AdminDashboard.css">
  <title>Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .all-content {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      grid-template-rows: repeat(2, auto);
      gap: 1rem;
    }

    .section1 {
      background: #f8f9fa;
      padding: 1rem;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    /* Summary cards layout */
    .fund-summary-section {
      width: 100%;
    }

    .fund-summary-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
      justify-content: space-between;
    }

    .fund-card {
      display: flex;
      justify-content: center;
      align-items: center;
      flex: 1 1 calc(50% - 1rem);
      min-width: 20px;
      padding: 0.1rem;
      border-radius: 10px;
      color: white;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .total-collected {
      background: linear-gradient(135deg, #28a745, #218838);
    }

    .total-expenses {
      background: linear-gradient(135deg, #dc3545, #c82333);
    }

    .current-balance {
      background: linear-gradient(135deg, #007bff, #0069d9);
    }

    .total-members {
      background: linear-gradient(135deg, #6f42c1, #5a32a3);
    }

    .fund-icon {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-right: 1rem;
    }

    .img-size {
      width: 50px;
      height: 50px;
    }

    .fund-details {
      margin: 0;
      padding: 0;
    }

    .fund-meta {
      font-size: 0.8rem;
      color: #f1f1f1;
    }

    .chart {
      width: 100%;
      padding: 1rem;
    }

    /* Button */
    .btn {
      display: inline-block;
      padding: 0.75rem 1.25rem;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      text-align: center;
      margin-top: 1rem;
      transition: background-color 0.3s, color 0.3s;
    }

    .btn-primary {
      background-color: #0d6efd;
      color: white;
    }

    .btn-secondary {
      background-color: #6c757d;
      color: white;
    }

    .btn-outline-dark {
      background-color: transparent;
      border: 2px solid #212529;
      color: #212529;
      transition: 0.3s;
    }

    .btn-outline-dark:hover {
      background-color: #212529;
      color: white;
    }

    /* Form and inputs */
    form {
      /* margin-bottom: 1rem; */
    }

    .form-section {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .form-select,
    .form-control {
      width: 100%;
      padding: 0.5rem;
      font-size: 1rem;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .row.g-3 {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
    }

    .col-md-4 {
      flex: 1 1 calc(33% - 1rem);
      min-width: 250px;
    }

    /* Tables */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 0.5rem;
      background: white;
    }

    table th,
    table td {
      border: 1px solid #ddd;
      padding: 0.75rem;
      text-align: left;
    }

    table th {
      background-color: #f1f1f1;
    }

    /* Chart section */
    canvas {
      width: 100% !important;
      max-height: 300px;
    }

    /* Responsive */
    @media (max-width: 768px) {

      .col-md-3,
      .col-md-4,
      .col-md-6 {
        flex: 1 1 100%;
      }
    }
  </style>

</head>

<body>

  <?php include('sidebar.php'); ?>
  <?php include('topbar.php'); ?>

  <main>

    <div class="all-content">

      <div class="section1">
        <!-- Summary Cards -->
        <div class="fund-summary-section">
          <h3>Fund Summary</h3>
          <div class="fund-summary-grid">
            <div class="fund-card total-collected">
              <div class="fund-icon">
                <img src="images/totalCollected.png" alt="Total Collected Icon" class="img-size">
              </div>
              <div class="fund-details">
                <h4>Total Collected</h4>
                <p id="totalIncome">Rs. <?php echo number_format($total_collected, 2); ?></p>
                <span class="fund-meta">From <?php echo $total_payments; ?> payments</span>
              </div>
            </div>

            <div class="fund-card total-expenses">
              <div class="fund-icon">
                <img src="images/totalExpenses.png" alt="Total Expenses Icon" class="img-size">
              </div>
              <div class="fund-details">
                <h4>Total Expenses</h4>
                <p id="totalExpenses">Rs. <?php echo number_format($total_expenses, 2); ?></p>
                <span class="fund-meta">All fund expenditures</span>
              </div>
            </div>

            <div class="fund-card current-balance">
              <div class="fund-icon">
                <img src="images/currentBalance.png" alt="Current Balance Icon" class="img-size">
              </div>
              <div class="fund-details">
                <h4>Current Balance</h4>
                <p id="presentValue">Rs. <?php echo number_format($current_balance, 2); ?></p>
                <span class="fund-meta">Available funds</span>
              </div>
            </div>

            <div class="fund-card total-members">
              <div class="fund-icon">
                <img src="images/totalMembers.png" alt="Total Members Icon" class="img-size">
              </div>
              <div class="fund-details">
                <h4>Total Members</h4>
                <p><?php echo $total_members; ?></p>
                <span class="fund-meta">Active in system</span>
              </div>
            </div>
          </div>
          <div class="share-summary">
            <button class="btn btn-outline-dark" onclick="shareDashboard()">Share Summary</button>
          </div>
        </div>
      </div>

      <div class="section1">
        <!-- Monthly Collection Chart -->
        <div class="chart">
          <div class=collection-chart>
            <h3>Monthly Fund Collection</h3>
            <canvas id="monthlyChart" height="800"></canvas>
          </div>
        </div>
      </div>

      <div class="section1">
        <!-- Filter by Month -->
        <h3>Filter Payees by Month and Year</h3>
        <form id="filterForm" class="form-section">
          <div class="form-fill-data">
            <select class="form-select" name="month" id="month">
              <option selected disabled>Select Month</option>
              <option>January</option>
              <option>February</option>
              <option>March</option>
              <option>April</option>
              <option>May</option>
              <option>June</option>
              <option>July</option>
              <option>August</option>
              <option>September</option>
              <option>October</option>
              <option>November</option>
              <option>December</option>
            </select>
            <input type="number" class="form-control" name="year" placeholder="Enter Year"
              style="width: 96%;margin-top:1rem" required>
          </div>
          <button type="submit" class="btn btn-primary">Filter Payees</button>
        </form>

        <!-- Payees Table -->
        <div class="row">
          <div class="col-md-6">
            <h5>Completed Payees</h5>
            <table class="table table-bordered" id="completedTable"></table>
          </div>
          <div class="col-md-6">
            <h5>Not Completed Payees</h5>
            <table class="table table-bordered" id="notCompletedTable"></table>
          </div>
        </div>
      </div>

      <div class="section1">
        <!-- RegNo Search -->
        <div class="my-4">
          <h3>Search Payment History</h3>
          <form id="searchForm" class="d-flex gap-2">
            <input type="text" class="form-control" id="regNoInput" placeholder="Enter Registration Number">
            <button class="btn btn-primary" type="submit">Search</button>
          </form>
          <table class="table mt-3" id="historyTable"></table>
        </div>
      </div>
    </div>


    <!-- Fetch dashboard values -->
    <script src="js/FetchDashboardValues.js"></script>

    <!-- Monthly Chart -->
    <script src="js/MonthlyChart.js"></script>

    <!-- Filter form -->
    <script src="js/FilterForm.js"></script>

    <!-- RegNo Search -->
    <script src="js/RegNoSearch.js"></script>

    <!-- Share Summary -->
    <script src="js/ShareSummary.js"></script>

  </main>
</body>

</html>