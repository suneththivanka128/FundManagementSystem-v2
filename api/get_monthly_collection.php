<?php
include __DIR__ . '/../config/database.php';

$result = [];
$sql = "
  SELECT ForMonth AS Month, SUM(Amount) AS TotalCollected
  FROM add_payment
  WHERE Status = 'active'
  GROUP BY ForMonth
  ORDER BY FIELD(ForMonth, 'January','February','March','April','May','June','July','August','September','October','November','December')
";
$res = $con->query($sql);
while ($row = $res->fetch_assoc()) {
  $result[] = $row;
}
header('Content-Type: application/json');
echo json_encode($result);
?>