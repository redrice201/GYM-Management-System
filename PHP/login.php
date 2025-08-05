<?php
include('connection.php');  
session_start();  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? ''; 
    $password = $_POST['password'] ?? '';  

    if (empty($username) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Username and Password are required.']);
        exit;
    }
    $query = "SELECT * FROM admins WHERE BINARY Username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $user['Password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $user['email']; 
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid Username or Password']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid Username or Password']);
    }
}
?>
