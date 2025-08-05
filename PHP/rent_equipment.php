<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $member_id = $_POST['member_id'];
    $equipment_names = isset($_POST['equipment']) ? explode(",", $_POST['equipment']) : [];

    if (empty($equipment_names)) {
        echo json_encode(['status' => 'error', 'message' => 'No equipment selected!.']);
        exit;
    }

    if ($conn->connect_error) {
        echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
        exit;
    }

   
    $equipment_names_string = implode(",", $equipment_names); 

    
    $stmt = $conn->prepare("UPDATE equipmentrentals SET Equipmentname = ? WHERE Memberid = ?");
    $stmt->bind_param("si", $equipment_names_string, $member_id);
    
    if ($stmt->execute()) {
        $log_stmt = $conn->prepare("INSERT INTO equipmentlogs (Equipmentuse, Memberid) VALUES (?, ?)");
        $log_stmt->bind_param("si", $equipment_names_string, $member_id);
        $log_stmt->execute();

        $stmt->close();
        $log_stmt->close();
        $conn->close();

        echo json_encode(['status' => 'success', 'message' => 'Equipment rental successful.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to process the rental.']);
    }
}
?>
