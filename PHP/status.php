<?php

include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    $status = $_POST['status'] ?? '';
    $member_id = $_POST['member_id'] ?? '';

    if (empty($status) || empty($member_id)) {
        echo "Invalid status or member ID!";
        exit;
    }

    if ($status !== 'In' && $status !== 'Out') {
        echo "Invalid status value!";
        exit;
    }

    $status = mysqli_real_escape_string($conn, $status);
    $member_id = mysqli_real_escape_string($conn, $member_id);

    $current_date = date('Y-m-d');

    $update_sql = "UPDATE members SET Status = '$status', Startdate = '$current_date' WHERE Memberid = $member_id";

    if (mysqli_query($conn, $update_sql)) {
        $log_sql = "INSERT INTO logs (Activity, Memberid) VALUES ('$status', '$member_id')";

        if (mysqli_query($conn, $log_sql)) {
            echo "Status updated to " . $status;

            if ($status === 'Out') {
                $update_equipment_sql = "UPDATE equipmentrentals SET Equipmentname = 'None' WHERE Memberid = $member_id";

                if (mysqli_query($conn, $update_equipment_sql)) {
                } else {
                    echo "Error updating equipment rental: " . mysqli_error($conn);
                }
            }
        } else {
            echo "Error logging activity: " . mysqli_error($conn);
        }
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request method or missing member ID!";
}
?>
