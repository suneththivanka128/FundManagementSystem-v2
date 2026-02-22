let collectedFunds = 10500;
        let pendingFunds = 4500;
        let expenses = 7500;
        let remainingBalance = 3000;

        // Animate Total Funds Counter
        function animateCounter(id, start, end, duration) {
            let obj = document.getElementById(id);
            let range = end - start;
            let startTime = null;

            function updateCounter(timestamp) {
                if (!startTime) startTime = timestamp;
                let progress = timestamp - startTime;
                let step = Math.min(start + (progress / duration) * range, end);
                obj.textContent = Math.floor(step);
                if (step < end) {
                    requestAnimationFrame(updateCounter);
                }
            }
            requestAnimationFrame(updateCounter);
        }

        // Initialize Charts
        function createChart(chartId, labels, data, colors, labelTitle) {
            const ctx = document.getElementById(chartId).getContext('2d');
            return new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: labelTitle,
                        data: [0, 0], // Start from 0 for animation
                        backgroundColor: colors
                    }]
                },
                options: {
                    responsive: true,
                    animation: {
                        duration: 2000,
                        easing: 'easeOutBounce'
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }

        // Animate Charts
        function animateChart(chart, newData) {
            setTimeout(() => {
                chart.data.datasets[0].data = newData;
                chart.update();
            }, 500);
        }

        // Share Summary Function
        function shareSummary() {
            let summaryText = `📊 Fund Management Summary\n
            ✅ Total Funds Collected: $${collectedFunds}
            📌 Collected: $${collectedFunds}
            ❌ Pending: $${pendingFunds}
            💰 Expenses: $${expenses}
            💵 Remaining Balance: $${remainingBalance}`;

            if (navigator.share) {
                navigator.share({
                    title: "Fund Summary",
                    text: summaryText
                }).then(() => console.log("Summary shared!"))
                .catch(err => console.log("Error sharing:", err));
            } else {
                alert("Sharing not supported on this browser.");
            }
        }

        // Run Animations on Page Load
        document.addEventListener("DOMContentLoaded", function() {
            animateCounter("total-funds", 0, collectedFunds, 2000);

            const fundChart = createChart(
                "fundChart",
                ["Collected", "Pending"],
                [collectedFunds, pendingFunds],
                ["#4CAF50", "#FF5733"],
                "Funds Status"
            );

            const expenseChart = createChart(
                "expenseChart",
                ["Expenses", "Remaining"],
                [expenses, remainingBalance],
                ["#FF9800", "#3F51B5"],
                "Fund Utilization"
            );

            animateChart(fundChart, [collectedFunds, pendingFunds]);
            animateChart(expenseChart, [expenses, remainingBalance]);
        });