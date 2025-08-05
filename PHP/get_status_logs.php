<?php
include('connection.php');

$query = "SELECT 
            l.Logid AS id, 
             CONCAT(m.Firstname, ' ', m.Middlename, ' ', m.Lastname) AS name, 
            m.profileimage AS image, 
             m.Contactnumber AS Contact, 
                m.Address AS Address, 
            l.Activity AS activity_or_equipment, 
            l.Activitydate AS date 
          FROM logs l
          JOIN members m ON l.Memberid = m.Memberid
          ORDER BY l.Activitydate DESC";  

$result = mysqli_query($conn, $query);

$logs = [];
while ($row = mysqli_fetch_assoc($result)) {
    $row['status'] = 'Status Update';
    $logs[] = $row;
}

echo json_encode($logs);

mysqli_close($conn);
?>
