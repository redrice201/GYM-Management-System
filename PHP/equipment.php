<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Add equipment
    if ($action == 'add_equipment' && !empty($_POST['equipment_name'])) {
        $equipment_name = $_POST['equipment_name'];

      
        $check_sql = "SELECT * FROM equipmentname WHERE equipment_name = '$equipment_name'";
        $check_result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
       
            $response = ['status' => 'error', 'message' => 'Equipment already exists'];
        } else {
          
            $sql = "INSERT INTO equipmentname (equipment_name) VALUES ('$equipment_name')";
            if (mysqli_query($conn, $sql)) {
                $response = ['status' => 'success', 'message' => 'Equipment added'];
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to add equipment'];
            }
        }
    }

    // Delete equipment
    elseif ($action == 'delete_equipment' && !empty($_POST['equipment_id'])) {
        $equipment_id = $_POST['equipment_id'];
        $sql = "DELETE FROM equipmentname WHERE equipment_id = $equipment_id";
        if (mysqli_query($conn, $sql)) {
            $response = ['status' => 'success', 'message' => 'Equipment deleted'];
        } else {
            $response = ['status' => 'error', 'message' => 'Failed to delete equipment'];
        }
    }

    // List Equipment
    elseif ($action == 'fetch_equipment') {
        $result = mysqli_query($conn, "SELECT * FROM equipmentname");
        $equipment = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $equipment[] = $row;
        }
        $response = ['status' => 'success', 'equipment' => $equipment];
    }

    echo json_encode($response);
}
?>
