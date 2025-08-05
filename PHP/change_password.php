<?php
session_start();
include('connection.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $email = $_POST['email']; 
    $query = "SELECT * FROM admins WHERE Username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        if (password_verify($currentPassword, $user['Password'])) {
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            $updateQuery = "UPDATE admins SET Password = ?, Email = ? WHERE Username = ?";
            $stmtUpdate = $conn->prepare($updateQuery);
            $stmtUpdate->bind_param("sss", $hashedNewPassword, $email, $username);

            if ($stmtUpdate->execute()) {
                echo json_encode(['success' => true, 'message' => 'Password and Email updated successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error updating password and email.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Incorrect current password.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Username not found.']);
    }
}
?>
