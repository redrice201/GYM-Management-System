<?php
include('connection.php');

// Count the number of members with "Member" membership type
$sql_member_count = "SELECT COUNT(*) AS member_count FROM members WHERE Membershiptype = 'Member'";
// Count the number of members with "Session" membership type
$sql_session_count = "SELECT COUNT(*) AS session_count FROM members WHERE Membershiptype = 'Session'";

$result_member = mysqli_query($conn, $sql_member_count);
$result_session = mysqli_query($conn, $sql_session_count);

$member_count = mysqli_fetch_assoc($result_member)['member_count'];
$session_count = mysqli_fetch_assoc($result_session)['session_count'];

echo json_encode([
    'member_count' => $member_count,
    'session_count' => $session_count
]);
?>
