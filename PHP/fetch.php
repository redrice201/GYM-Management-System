<?php
include('connection.php');

$sql = "SELECT * FROM members LEFT JOIN equipmentrentals ON members.Memberid = equipmentrentals.Memberid";
$result = mysqli_query($conn, $sql);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
?>