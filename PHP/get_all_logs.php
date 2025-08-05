<?php
include('connection.php');

$equipmentQuery = "SELECT 
                    e.Logid AS id, 
                    CONCAT(m.Firstname, ' ', m.Middlename, ' ', m.Lastname) AS name, 
                    m.profileimage AS image, 
                     m.Contactnumber AS Contact, 
                      m.Address AS Address, 
                    e.Equipmentuse AS activity_or_equipment, 
                    e.Logtimestamp AS date 
                  FROM equipmentlogs e
                  JOIN members m ON e.Memberid = m.Memberid";
$equipmentResult = mysqli_query($conn, $equipmentQuery);
$logs = [];

while ($row = mysqli_fetch_assoc($equipmentResult)) {
    $row['log_type'] = 'Equipment Use';
    $logs[] = $row;
}

$statusQuery = "SELECT 
                l.Logid AS id, 
                CONCAT(m.Firstname, ' ', m.Middlename, ' ', m.Lastname) AS name, 
                m.profileimage AS image, 
                 m.Contactnumber AS Contact, 
                    m.Address AS Address, 
                l.Activity AS activity_or_equipment, 
                l.Activitydate AS date 
              FROM logs l
              JOIN members m ON l.Memberid = m.Memberid";
$statusResult = mysqli_query($conn, $statusQuery);

while ($row = mysqli_fetch_assoc($statusResult)) {
    $row['log_type'] = 'Status Update';
    $logs[] = $row;
}

usort($logs, function ($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});

echo json_encode($logs);

mysqli_close($conn);
?>
