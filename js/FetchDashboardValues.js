// Fetch dashboard values
fetch('api/get_summary.php')
  .then(res => res.json())
  .then(data => {
    document.getElementById('presentValue').textContent = 'Rs. ' + data.presentValue;
    document.getElementById('totalIncome').textContent = 'Rs. ' + data.totalIncome;
    document.getElementById('totalExpenses').textContent = 'Rs. ' + data.totalExpenses;

    // Store for sharing
    window.dashboardSummary = data;
  });