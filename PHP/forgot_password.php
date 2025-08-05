<?php
include('connection.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

session_start(); 

$verificationCode = rand(100000, 999999);

$query = "SELECT email FROM admins WHERE AdminId = 1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row['email'];
    $updateQuery = "UPDATE admins SET verification_code = '$verificationCode' WHERE AdminId = 1";
    $conn->query($updateQuery);

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'markself96@gmail.com';
        $mail->Password = 'rjqlgezzedhigmtl'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('markself96@gmail.com', 'HIGHER LEVEL FITNESS GYM');
        $mail->addAddress($email); 

        $mail->Subject = 'Password Reset Verification Code';
        $mail->Body .= "Dear Admin,\n\n";
        $mail->Body .= "Greetings from Higher Level Fitness Gym!\n\n";
        $mail->Body .= "We received a request to reset your admin password. Below is your verification code to complete the process:\n\n";
        $mail->Body .= "Verification Code: $verificationCode\n\n";
        $mail->Body .= "This code is for your use only. Please do not share it with anyone else.\n\n";
        $mail->Body .= "If you did not request this change, please ignore this message.\n\n";
        $mail->Body .= "Thank you for managing Higher Level Fitness Gym.\n\n";
        $mail->Body .= "Best regards,\n";
        $mail->Body .= "The Higher Level Fitness Gym";
        
        
        

        if ($mail->send()) {
            
session_start();
            $_SESSION['email_send_failure'] = true; 
            header('Location: reset_password.php');
            exit;
        } else {
            $_SESSION['email_send_failure'] = true; 
            header('Location: 404.php');
            exit;
        }
    } catch (Exception $e) {
        $_SESSION['email_send_failure'] = true;
        header('Location: 404.php');
        exit;
    }
} else {
    echo "<script>alert('User not found.');</script>";
}
?>
