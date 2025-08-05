<?php

session_start(); 

if (!isset($_SESSION['username'])) {
    header('Location: index.php');  
    exit;
}

include('PHP/connection.php');
$sql = "SELECT * FROM equipmentname";
$result = mysqli_query($conn, $sql);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    
    <link rel="icon" href="src/logo-icon.png" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
   
    <script type="module" src="icons/node_modules/ionicons/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="icons/node_modules/ionicons/dist/ionicons/ionicons.js"></script>
</head>


<body>

    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="barbell-outline"></ion-icon>
                        </span>
                        <span class="title">Higher Level Fitness Gym</span>
                    </a>
                </li>

                <li>
                    <a href="#" id="dashboard">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="#" id="membersession">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Session / Member</span>
                    </a>
                </li>

          
                <li>
                    <a href="#" id="logs-sidebar">
                        <span class="icon">
                        <ion-icon name="time-outline"></ion-icon>


                        </span>
                        <span class="title">Logs / Rent</span>
                    </a>
                </li>
              

                <li>
                    <a href="#" id="password-sidebar">
                        <span class="icon">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                        </span>
                        <span class="title">Change Password</span>
                    </a>
                </li>
                

                <li>
                <a href="#" id="logout">
                    <span class="icon">
                        <ion-icon name="log-out-outline"></ion-icon>
                    </span>
                    <span class="title">Sign Out</span>
                </a>
            </li>
            </ul>
        </div>

        <div class="main">

            <div class="topbar">

                
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <div class="search" id="searches">
                    <label>
                        <input type="text" id='inputs1' placeholder="Search Member" oninput="filterTable('All')">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>
                
                
                

              
              </div>

              <div class="content-dashboard" id='dashboard-body'>

                <div>
                    <p class="dashboard-title">Dashboard Higher Level</h1>
                </div>
                    
                <div class="cardBox">
                <div class="card">
                            <div>
                                <div class="numbers member"></div> 
                                <div class="cardName">Member</div>
                            </div>
                            <div class="iconBx">
                                <ion-icon name="people-outline"></ion-icon>
                            </div>
                        </div>

                        <div class="card">
                            <div>
                                <div class="numbers session"></div>
                                <div class="cardName">Session</div>
                            </div>
                            <div class="iconBx">
                                <ion-icon name="people-outline"></ion-icon>
                            </div>
                        </div>

    
                   
                </div>
              </div>



              <div class="content-dashboard" id="customer-body">
               

                <div class="cardHeader">
                    <h2 class="titles1">Customer</h2>

                    <div class="button-member">
                        <button onclick="filterTable('All')">All</button>
                        <button onclick="filterTable('Session')">Session</button>
                        <button onclick="filterTable('Member')">Member</button>
                        <select class="log">
                            <option value="All">All</option>
                            <option value="In">In</option>
                            <option value="Out">Out</option>
                        </select>
                        <button id="rentequipment">
                            <ion-icon name="add-circle"></ion-icon>
                        </button>
                        <button id="addmember">
                            <ion-icon name="person-add"></ion-icon>
                        </button>

                       

                      
                    </div>
                </div>
                <div class="details">
                <div class="recentOrders">
               

                    <table>
                        <thead>

                            <tr>
                                
                                <td>Image</td>
                                <td>Name</td>
                                
                                <td>Contact</td>
                                <td>Address</td>
                                
                        
                           
                               
                                
                                <td>Register</td>
                                <td>Status</td>
                                <td>Rent Equip.</td>
                               
                                
                            </tr>
                        </thead>

                        <tbody>
                       
                        </tbody>
                    </table>

                    <div id="no-results" style="display: none; text-align: center; margin-top: 10px; color: red;">
                        No Data Found
                    </div>

                </div>
</div>



















            <div class="modal" id="modal-member">
                <div class="modal-body">
                    <div class="modal-content">
                    <button id="exit" class='alll'>&times;</button>
                    <div class="title-modal">
                        <p>Add Customer</p>
                    </div>
                    <div class="images">
                        <div class="content-images">
                        <img id="image-member" src="src/logo.jpg">
  
                    </div>
                    </div>
                <div class='scroll'>
                    <form id="memberForm" class="members">
                    <input type="file" accept="image/*" id="member-img" style="display: none;" onchange="Images(event)">

                
                        <div class="fullname">
                        <div class="form-icons1">
                            <div class="icons">
                                <ion-icon name="person"></ion-icon>
                            </div>
                            <input type="text" id="firstName" placeholder="First Name" required>
                            </div>
                            <div class="form-icons1">
                            <div class="icons">
                                <ion-icon name="person"></ion-icon>
                            </div>
                            <input type="text" id="middleName" placeholder="Middle Name" required>
                            </div>
                            <div class="form-icons1">
                            <div class="icons">
                                <ion-icon name="person"></ion-icon>
                            </div>
                            <input type="text" id="lastName" placeholder="Last Name" required>
</div>
                     
                        </div>
                        <div class="fullname">
                        <div class="form-icons1">
                            <div class="icons">
                                <ion-icon name="call"></ion-icon>
                            </div>
                            <input type="number" id="contactNumber" placeholder="Contact Number"  required maxlength="11" oninput="validateContact(this)">
                            </div>
                            <div class="form-icons1">
                            <div class="icons">
                                <ion-icon name="location"></ion-icon>
                            </div>
                            <input type="text" id="address" placeholder="Address" required>
                            </div>
                            <div class="form-icons1">
                            <div class="icons">
                                <ion-icon name="clipboard"></ion-icon>
                            </div>
                            <select id="registerType" required>
                                <option selected disabled>Register</option>
                                <option value="Member">Member</option>
                                <option value="Session">Session</option>
                            </select>
                        </div>
                        </div>
                        <div class="fullname">
                        <div class="form-icons1">
                            <div class="icons">
                                <ion-icon name="time"></ion-icon>
                            </div>
                            <input type="text" disabled id="start-member">
                        </div>
                        <div class="form-icons1">
                        <div class="icons">
                                <ion-icon name="time"></ion-icon>
                        </div>
                            <input type="text" disabled id="end-member">
                        </div>
                     
                        </div>


                    <button type="button" id="submitButton" class="submitting alll on" >Register</button>
                </form>
</div>
                </div>
            </div>
                </div>



































                <div class="modal" id="modal-biggerimg">
                    <div class="modal-body">
                        <div class="modal-content">
                            <button id="exit12" class="close alll">&times;</button>

              <img src="assets/imgs/customer01.jpg" id="images1" class="img1">

                            </div>
                            </div>
                            </div>












































                            <div class="modal" id="modal-status">
                                <div class="modal-body">
                                    <div class="modal-content" id="modal-form-status">
                                        <button id="exit-status" class="close alll">&times;</button>
                                        <div class="title-modal">
                                            <p>Status</p>
                                        </div>
                                        <form class="form-status">
                                            <input type="hidden" id="status-member-id" name="member_id">
                                            <div class="seperate">
                                            <div class="radio-status-form"><label>In</label><input type="radio" name="status" class="In" value="In"></div>
                                            <div class="radio-status-form"><label>Out</label><input type="radio" name="status" class="Out" value="Out"></div>
                                            </div>
                                            <button  class="submitting alll on">Change</button>
                                        </form>
                                    </div>
                                </div>
                            </div>




                            










                         






















                    



                            <div class="modal" id="modal-rent">
                            <div class="modal-body">
                                <div class="modal-content" id="modal-form-rent">
                                    <button id="exit123" class="close alll">&times;</button>
                                    <div class="title-modal">
                                        <p>Rent Equipment</p>
                                    </div>
                                    <form class="form-rent" id="rentForm">
                                        <input type="hidden" id="rent-member-id" name="member_id">
                                        <div class="moreradio" id="equipment-list">
                                        
                                        </div>
                                        <button type="submit" class="submitting alll on">Rent</button>
                                    </form>
                                </div>
                            </div>
                        </div>























<div class="modal" id="editModal">
    <div class="modal-body">
        <div class="modal-content" id="modal-details-employee">
        <button onclick="closeModal()"; class="close alll">&times;</button>
  <div class="title-modal">
    <p>Edit Member Details</p>
  </div>
    <form id="editForm">
    <div class="form-icons2">
        <div class="icons">
            <ion-icon name="person"></ion-icon>
        </div>
        <input type="text" id="firstname" placeholder="First Name" required>
    </div>
    <div class="form-icons2">
        <div class="icons">
            <ion-icon name="person"></ion-icon>
        </div>
        <input type="text" id="middlename" placeholder="Middle Name" required>
    </div>
    <div class="form-icons2">
        <div class="icons">
            <ion-icon name="person"></ion-icon>
        </div>
        <input type="text" id="lastname" placeholder="Last Name" required>
    </div>
    <div class="form-icons2">
        <div class="icons">
        <ion-icon name="location"></ion-icon>
        </div>
        <input type="text" id="address1" placeholder="Address" required>
    </div>
    <div class="form-icons2">
        <div class="icons">
        <ion-icon name="call"></ion-icon>
        </div>
        <input type="text" id="contact" placeholder="Contact No." required maxlength="11" oninput="validateContact(this)">

    </div>
      
        
       
    <input type="text" id="memberid" style="display:none" />

      <button type="button" onclick="saveChanges()"  class="submitting alll on">Save Changes</button>
    </form>
  </div>
</div>
</div>







                            <div class="modal" id="modal-register">
                                <div class="modal-body">
                                    <div class="modal-content" id="modal-form-register">
                                        <button id="exit-register" class="close alll">&times;</button>
                                        <div class="title-modal">
                                            <p>Register</p>
                                        </div>
                                        <form class="form-register">
                                            <input type="hidden" id="register-member-id" name="member_id">
                                            <div class="seperate">
                                            <div class="radio-status-form"><label>Member</label><input type="radio" name="Register" class="Member" value="Member"></div>
                                            <div class="radio-status-form"><label>Session</label><input type="radio" name="Register" class="Session" value="Session"></div>
                                            </div>
                                            <button  class="submitting alll on">Change</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
            

































                            
                            <div class="modal" id="modal-equipment">
                                <div class="modal-body">
                                    <div class="modal-content" id='renting-equipment'>
                                        <button id="close-modal" class="close alll">&times;</button>
                                        <div class="title-modal">
                                            <p>Add Equipment</p>
                                        </div>
                                        <form class="form-register" id="addEquipmentForm">
                                          
                                                <div class="radio-status-form">
                                                    <input type="text" id="newEquipment" name="new_equipment" placeholder="New Equipment" required>
                                                </div>
                                           
                                            <button type="submit" class="submitting alll on"><ion-icon name="add-circle-outline"></ion-icon>
                                            </button>
                                        </form>

                                        <div class="equipment-list">
                                           
                                            <div id="equipmentList">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                


            















             
                  

                
                <div id="error-alert">
                    <div class="erros-alert">
                    <div id="error">
                      
                    </div>



                </div>

            </div>

           
        </div>


        <div class="content-dashboard" id="password-body" style="display:none">
                    <div class="admin-body">
                <div class='admin'>
                 
                <form id="change-password-form">
                <form id="change-password-form">
    <div class="title-dashboard">
        <p>Higher Level Fitness Gym</p>
    </div>
    
    <div class="form-icons">
        <div class="icons">
            <ion-icon name="person"></ion-icon>
        </div>
        <input type="text" id="username" placeholder="Username" value="<?php echo $_SESSION['username']; ?>">
    </div>

    <div class="form-icons">
        <div class="icons">
            <ion-icon name="mail"></ion-icon>
        </div>
        <input type="email" id="email" placeholder="Email" value="<?php echo $_SESSION['email']; ?>" required>
    </div>

    <div class="form-icons">
        <div class="icons">
            <ion-icon name="lock-closed"></ion-icon>
        </div>
        <input type="password" id="current-password" placeholder="Current Password">
    </div>

    <div class="form-icons">
        <div class="icons">
            <ion-icon name="lock-open"></ion-icon>
        </div>
        <input type="password" id="new-password" placeholder="New Password">
    </div>

    <div class="form-icons">
        <div class="icons">
            <ion-icon name="shield-checkmark"></ion-icon>
        </div>
        <input type="password" id="confirm-password" placeholder="Confirm New Password">
    </div>
    
    <button type="submit" class="submitting on">Change Password</button>
</form>




                </div>
                </div>

                 <div id="error-alert1">
                    <div class="erros-alert">
                    <div id="error1">
                      
                    </div>



                </div>

            </div>
                </div>

        


    <div class="content-dashboard" id="logs-body" style='display:none'>
    <div class="cardHeader">
        <h2 class="titles1">History</h2>
        <div class="button-member">
            <button onclick="handleLogSelection('all')">All</button>
            <button onclick="handleLogSelection('rent')">Rent Equipment</button>
            <button onclick="handleLogSelection('status')">Logs</button>
        </div>
    </div>
    <div class="details">
        <div class="recentOrders">
            <table>
                <thead>
                    <tr>
                        <td>Image</td>
                        <td>Name</td>
                        <td>Contact</td>
                        <td>Address</td>
                        <td>Activity/Equipment</td>
                        <td>Date</td>
                    </tr>
                </thead>
                <tbody id="logs-table-body"></tbody>
            </table>
            <div id="no-results" style="display: none; text-align: center; margin-top: 10px; color: red;">
    No Data Found
</div>


            
        </div>
    </div>
</div>

<div id="error-alert2" style="display:none;">
    <div class="erros-alert">
        <div id="error2"></div>
    </div>
</div>


        



    </div>
    <script src="js/ajax.js"></script>
    <script src="js/members.js"></script>
    <script src="js/table.js"></script>
    <script src="assets/js/main.js"></script>

  
    <script>
        </script>
</body>

</html>