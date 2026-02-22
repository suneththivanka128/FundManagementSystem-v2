<?php
include __DIR__ . '/../config/database.php';

$reg = $_GET['reg'];
$response = [];

// Use Prepared Statement to prevent SQL injection
$stmt = $con->prepare("
  SELECT ForYear, ForMonth, Amount, PaymentDate
  FROM add_payment
  WHERE RegistrationNo = ?
  ORDER BY ForYear, FIELD(ForMonth, 'January','February','March','April','May','June','July','August','September','October','November','December')
");
$stmt->bind_param("s", $reg);
$stmt->execute();
$res = $stmt->get_result();

while ($row = $res->fetch_assoc()) {
  $response[] = $row;
}
$stmt->close();

header('Content-Type: application/json');
echo json_encode($response);
?>