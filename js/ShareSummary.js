// Share Summary
function shareDashboard() {
  const data = window.dashboardSummary;
  if (!data) return alert("Dashboard summary is not loaded yet.");
  const text = `Dashboard Summary:\nPresent Value: Rs. ${data.presentValue}\nTotal Income: Rs. ${data.totalIncome}\nTotal Expenses: Rs. ${data.totalExpenses}`;
  if (navigator.share) {
    navigator.share({
      title: "Fund Summary",
      text: text
    }).catch(err => alert("Sharing failed: " + err));
  } else {
    prompt("Copy and share the summary:", text);
  }
}