<?php
include('connection.php');

$query = "SELECT 
            e.Logid AS id, 
            CONCAT(m.Firstname, ' ', m.Middlename, ' ', m.Lastname) AS name, 
            m.profileimage AS image, 
            m.Contactnumber AS Contact, 
               m.Address AS Address, 
            e.Equipmentuse AS activity_or_equipment, 
            e.Logtimestamp AS date 
          FROM equipmentlogs e
          JOIN members m ON e.Memberid = m.Memberid
          ORDER BY e.Logtimestamp DESC";  

$result = mysqli_query($conn, $query);

$logs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $row['status'] = 'Equipment Use';
    $logs[] = $row;
}

echo json_encode($logs);

mysqli_close($conn);
?>
