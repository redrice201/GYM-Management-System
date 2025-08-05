<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['firstName']) && isset($_POST['middleName']) && isset($_POST['lastName'])) {

    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $contactNumber = $_POST['contactNumber'];
    $address = $_POST['address'];
    $registerType = $_POST['registerType'];
    $start = $_POST['startmember'];
    $end = $_POST['endmember'];
    $status = 'In';
    $imgFolder = "";
    

    if (isset($_FILES['memberImg']) && $_FILES['memberImg']['error'] == 0) {
        $imgName = $_FILES['memberImg']['name'];
        $imgTmpName = $_FILES['memberImg']['tmp_name'];
        $imgFolder = "uploads/" . $imgName;
        move_uploaded_file($imgTmpName, $imgFolder); 
    }

    $sql1 = "INSERT INTO members (Firstname, Middlename, Lastname, Contactnumber, Address, Membershiptype, Profileimage, Startdate, Enddate, Status) 
             VALUES ('$firstName', '$middleName', '$lastName', '$contactNumber', '$address', '$registerType', '$imgFolder' , '$start', '$end', '$status')";
    
    if (mysqli_query($conn, $sql1)) {
        $memberId = mysqli_insert_id($conn);

        $sql2 = "INSERT INTO logs (MemberId, Activity) VALUES ('$memberId', 'In')";
        if (mysqli_query($conn, $sql2)) {
            $sql3 = "INSERT INTO equipmentrentals (Memberid, Equipmentname) VALUES ('$memberId', 'None')";
            if (mysqli_query($conn, $sql3)) {
                echo "Has been registered successfully!";
            } else {
                echo "Error inserting into equipmentrentals: " . mysqli_error($conn);
            }
        } else {
            echo "Error inserting into logs: " . mysqli_error($conn);
        }
    } else {
        echo "Error inserting into members: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Invalid request! Missing required fields.";
}
?>
