<?php
session_start();

if (!isset($_SESSION['email_send_failure']) || $_SESSION['email_send_failure'] !== true) {
    header('Location: ../index.php'); 
    exit;
}

unset($_SESSION['email_send_failure']);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../css/404.css">
  
  <link rel="icon" href="src/logo-icon.png" type="image/x-icon">
  <script type="module" src="../icons/node_modules/ionicons/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="../icons/node_modules/ionicons/dist/ionicons/ionicons.js"></script>
  <title>Connection Error</title>
</head>
<style>
      body{
    background-image: url('../src/background.jpg');
 

}
</style>
<body>

<div class="container">
        <div class="landing-form">
       <div class="nointernet">
            <img src="../src/nointernet.png" alt="No Internet">
       </div>
    <h1>OFFLINE</h1>
    <h4>Please check your internet connection</h4>
 
    <a href="../index.php" class="button"> <b><ion-icon name="arrow-back-outline"></ion-icon><b> </a>

  </div>
</div>
</body>
</html>