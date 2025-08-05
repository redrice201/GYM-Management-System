<?php

include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['member_id']) && isset($_POST['register_type']) && isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $member_id = $_POST['member_id'];
    $register_type = $_POST['register_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if (empty($member_id) || empty($register_type) || empty($start_date) || empty($end_date)) {
        echo "Invalid member ID, registration type, start date, or end date!";
        exit;
    }

    $register_type = mysqli_real_escape_string($conn, $register_type);
    $start_date = mysqli_real_escape_string($conn, $start_date);
    $end_date = mysqli_real_escape_string($conn, $end_date);

    $sql = "UPDATE members SET Membershiptype = '$register_type', Startdate = '$start_date', Enddate = '$end_date' WHERE Memberid = '$member_id'";

    if (mysqli_query($conn, $sql)) {
        echo "Registration updated to " . $register_type;
    } else {
        echo "Error updating registration: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request!";
}
?>
