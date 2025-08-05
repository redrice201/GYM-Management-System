<?php
include('connection.php');

if (isset($_POST['member_id']) && isset($_POST['firstName']) && isset($_POST['middleName']) && isset($_POST['lastName']) && isset($_POST['contactNumber']) && isset($_POST['address'])) {

    $memberId = $_POST['member_id'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $address = $_POST['address'];
    $contactNumber = $_POST['contactNumber'];
    $query = "UPDATE members SET Firstname = ?, Middlename = ?, Lastname = ?, Address = ?, Contactnumber = ? WHERE Memberid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $firstName, $middleName, $lastName, $address, $contactNumber, $memberId);

    if ($stmt->execute()) {
        echo "Member updated successfully!";
    } else {
        echo "Error updating member.";
    }
}
?>
