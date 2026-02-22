// Monthly Chart
fetch('api/get_monthly_collection.php')
  .then(res => res.json())
  .then(data => {
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(ctx, {
      type: 'line',
      data: {
        labels: data.map(row => row.Month),
        datasets: [{
          label: 'Collected (Rs.)',
          data: data.map(row => row.TotalCollected),
          fill: false,
          borderColor: 'blue',
          tension: 0.1
        }]
      }
    });
  });