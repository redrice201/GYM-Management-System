<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $member_id = $_POST['member_id'];
    $equipment_status = $_POST['equipment'];  

    if (empty($equipment_status)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid equipment status.']);
        exit;
    }

    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE equipmentrentals SET Equipmentname = ? WHERE Memberid = ?");
    $stmt->bind_param("si", $equipment_status, $member_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Equipment rental equip. updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update equipment rental.']);
    }

    $stmt->close();
    $conn->close();
}
?>
