<?php
    session_start();
    unset($_SESSION['email_send_failure']);
    unset( $_SESSION['email']);
    unset( $_SESSION['username']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <link rel="icon" href="src/logo-icon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/index.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
   
    <script type="module" src="icons/node_modules/ionicons/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="icons/node_modules/ionicons/dist/ionicons/ionicons.js"></script>
</head>
<style>
  body{
    background-image: url('src/background.jpg');
 

}
</style>
<body>
<div class="container">
        <div class="landing-form">
            <form id="login-form">
                <div class="title">
                    <img src="src/logo.jpeg" alt="Image">
                </div>
                <div class="gap">
                    <div class="gap">
                    <label>Username</label>
                    <div class="icon">
                    <div class="icons">
                    <ion-icon name="person"></ion-icon>

                   
                    </div>
                    <input type="text" id="username" placeholder="Username" required>
                    </div>
                  
                    </div>
                    <div  class="gap">
                    <label>Password</label>
                    <div class="icon">
                        <div class="icons">
                        <ion-icon name="lock-closed"></ion-icon>
                        </div>
                    <input type="password" id="password" placeholder="Password" required>
                    </div>
                    </div>
                    <button type="submit">Login</button>
                </div>
                <a href="PHP/forgot_password.php" id="forgot-password" >Forgot Password?</a>
            </form>
          
        </div>
        <div id="erroralert" style="display: none;">
        <div class="erros-alert">
                <div id="error"></div>
        </div>
            </div>
    </div>

    <script src="js/login.js"></script>
</body>
</html>