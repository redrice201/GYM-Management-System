<?php
include('connection.php');  

$sql = "SELECT * FROM equipmentname"; 
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='radio-status-form'>
                <label>{$row['equipment_name']}</label>
                <input type='checkbox' name='equipment[]' value='{$row['equipment_name']}'>
              </div>";
    }
} else {
    echo "<div class='radio-status-form'>No Data Found!</div>";
}
?>
