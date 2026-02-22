<?php
include __DIR__ . '/../config/database.php';

$month = $_GET['month'];
$year = $_GET['year'];

$response = ['completed' => [], 'notCompleted' => []];

// Completed payees using Prepared Statement
$stmt1 = $con->prepare("
  SELECT m.RegNo, CONCAT(m.FirstName, ' ', m.LastName) AS FullName, p.Amount
  FROM memberregistration m
  JOIN add_payment p ON m.RegNo = p.RegistrationNo
  WHERE p.ForMonth = ? AND p.ForYear = ? AND p.Status = 'active'
");
$stmt1->bind_param("ss", $month, $year);
$stmt1->execute();
$res1 = $stmt1->get_result();
while ($row = $res1->fetch_assoc()) {
  $response['completed'][] = $row;
}
$stmt1->close();

// Not completed payees using Prepared Statement
$stmt2 = $con->prepare("
  SELECT m.RegNo, CONCAT(m.FirstName, ' ', m.LastName) AS FullName
  FROM memberregistration m
  WHERE m.status = 'Approve' AND m.RegNo NOT IN (
    SELECT RegistrationNo FROM add_payment 
    WHERE ForMonth = ? AND ForYear = ? AND Status = 'active'
  )
");
$stmt2->bind_param("ss", $month, $year);
$stmt2->execute();
$res2 = $stmt2->get_result();
while ($row = $res2->fetch_assoc()) {
  $response['notCompleted'][] = $row;
}
$stmt2->close();

header('Content-Type: application/json');
echo json_encode($response);
?>