<?php
include __DIR__ . '/../config/database.php';

$result = [
    'presentValue' => 0,
    'totalIncome' => 0,
    'totalExpenses' => 0
];

// Total income
$incomeRes = $con->query("SELECT SUM(Amount) AS TotalIncome FROM add_payment WHERE Status='active'");
if ($row = $incomeRes->fetch_assoc()) {
    $result['totalIncome'] = (float) ($row['TotalIncome'] ?? 0);
}

// Total expenses
$expenseRes = $con->query("SELECT SUM(Amount) AS TotalExpenses FROM expenses");
if ($row = $expenseRes->fetch_assoc()) {
    $result['totalExpenses'] = (float) ($row['TotalExpenses'] ?? 0);
}

// Present value
$result['presentValue'] = $result['totalIncome'] - $result['totalExpenses'];

header('Content-Type: application/json');
echo json_encode($result);
?>