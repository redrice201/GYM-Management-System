<?php
include('connection.php');
session_start();

if (!isset($_SESSION['email_send_failure'])) {
    header('Location: ../index.php');  
    exit;
}
if (!isset($_SESSION['email_send_failure']) || $_SESSION['email_send_failure'] === false) {
    header('Location: ../index.php'); 
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $verificationCode = $_POST['verificationCode'];
    $newPassword = $_POST['newPassword'];

    $query = "SELECT * FROM admins WHERE verification_code = '$verificationCode'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username = $row['Username'];

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $updateQuery = "UPDATE admins SET password = '$hashedPassword', verification_code = NULL WHERE Username = '$username'";
        if ($conn->query($updateQuery)) {
           
            echo json_encode(['success' => true, 'message' => 'Password reset successfully.']);
            
            unset($_SESSION['email_send_failure']);

         
        } else {
           
            echo json_encode(['success' => false, 'message' => 'Failed to reset password.']);
        }
    } else {
       
        echo json_encode(['success' => false, 'message' => 'Invalid verification code.']);
    }
    exit; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="../src/logo-icon.png" type="image/x-icon">
    <link rel="stylesheet" href="../css/index.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script type="module" src="../icons/node_modules/ionicons/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="../icons/node_modules/ionicons/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
  body {
    background-image: url('../src/background.jpg');
  }
 
</style>
<body>

<div class="container">
    <div class="landing-form">
        <form id="resetPasswordForm" method="POST">
            <div class="title">
                <img src="../src/logo.jpeg" alt="Image">
            </div>
            <div class="gap">
                <label>Verification Code:</label>
                <div class="icon">
                    <div class="icons">
                        <ion-icon name="person"></ion-icon>
                    </div>
                    <input type="text" name="verificationCode" required placeholder="Verification Code">
                </div>
            </div>
            <div class="gap">
                <label>New Password:</label>
                <div class="icon">
                    <div class="icons">
                        <ion-icon name="lock-closed"></ion-icon>
                    </div>
                    <input type="password" name="newPassword" required placeholder="New Password">
                </div>
                <button type="submit" class="button1">Reset Password</button>
            </div>
            
        </form>
    </div>

    <div id="erroralert">
        <div class="erros-alert">
            <div id="error"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#resetPasswordForm').submit(function(e) {
            e.preventDefault();
            
            $.ajax({
                url: 'reset_password.php',
                type: 'POST',
                data: $(this).serialize(), 
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#error').text(response.message);
                        $('#erroralert').css('display', 'block');
                        $('#error').css('background-color', '#4CAF50'); 
                        setTimeout(function() {
                            window.location.href = '../index.php';
                        }, 3000);
                    } else {
                        $('#error').text(response.message);
                        $('#erroralert').css('display', 'block');
                        $('#error').css('background-color', '#F44336'); 
                        setTimeout(function() {
                            $('#erroralert').fadeOut();
                        }, 2000);
                    }
                },
                error: function() {
                    $('#error').text('An error occurred. Please try again later.');
                    $('#erroralert').css('display', 'block');
                    $('#error').css('background-color', '#F44336'); 
                    setTimeout(function() {
                        $('#erroralert').fadeOut(); 
                    }, 2000);
                }
            });
        });
    });
</script>

</body>
</html>
