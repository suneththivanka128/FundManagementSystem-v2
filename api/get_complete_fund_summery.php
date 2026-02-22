<?php
include __DIR__ . '/../config/database.php';

// Get complete fund summary
$total_collected_sql = "SELECT SUM(Amount) as total FROM add_payment WHERE Status='active'";
$total_expenses_sql = "SELECT SUM(Amount) as total FROM expenses";
$member_count_sql = "SELECT COUNT(*) as total FROM memberregistration WHERE status='Approve'";
$active_payments_sql = "SELECT COUNT(*) as total FROM add_payment WHERE Status='active'";

$total_collected_result = $con->query($total_collected_sql);
$total_expenses_result = $con->query($total_expenses_sql);
$member_count_result = $con->query($member_count_sql);
$active_payments_result = $con->query($active_payments_sql);

$total_collected = $total_collected_result->fetch_assoc()['total'] ?? 0;
$total_expenses = $total_expenses_result->fetch_assoc()['total'] ?? 0;
$current_balance = $total_collected - $total_expenses;
$total_members = $member_count_result->fetch_assoc()['total'] ?? 0;
$total_payments = $active_payments_result->fetch_assoc()['total'] ?? 0;
?>