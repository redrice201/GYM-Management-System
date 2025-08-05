<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['firstName']) && isset($_POST['middleName']) && isset($_POST['lastName'])) {

    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];

    $sql = "SELECT * FROM members WHERE Firstname = '$firstName' AND Middlename = '$middleName' AND Lastname = '$lastName'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "exists";
    } else {
        echo "not exists";
    }

    mysqli_close($conn);
} else {
    echo "Invalid request!";
}
?>
