<?php

include('connection.php');

$current_date = date('Y-m-d');

$member_ids_query = "
    SELECT Memberid 
    FROM members 
    WHERE DATE(Startdate) <= DATE_SUB('$current_date', INTERVAL 1 YEAR)
";

$result = mysqli_query($conn, $member_ids_query);

if ($result && mysqli_num_rows($result) > 0) {
    $member_ids = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $member_ids[] = $row['Memberid'];
    }

    $member_ids_string = implode(',', $member_ids);
    if (!empty($member_ids)) {
        $delete_logs_query = "
            DELETE FROM logs 
            WHERE Memberid IN ($member_ids_string)
        ";
        mysqli_query($conn, $delete_logs_query);
        $delete_equipmentrentals_query = "
            DELETE FROM equipmentrentals 
            WHERE Memberid IN ($member_ids_string)
        ";
        mysqli_query($conn, $delete_equipmentrentals_query);
        $delete_equipmentlogs_query = "
            DELETE FROM equipmentlogs 
            WHERE Memberid IN ($member_ids_string)
        ";
        mysqli_query($conn, $delete_equipmentlogs_query);
        $delete_members_query = "
            DELETE FROM members 
            WHERE Memberid IN ($member_ids_string)
        ";
        mysqli_query($conn, $delete_members_query);

        echo "Old members and related data deleted successfully.";
    }
} else {
    echo "No old members to delete.";
}
mysqli_close($conn);
?>
