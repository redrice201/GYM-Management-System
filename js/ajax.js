

let erroralert = document.getElementById('error-alert');
let error = document.getElementById('error');



















//equipmentlist

function updateEquipmentList() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "PHP/add_equipment.php", true); 
    xhr.onload = function() {
        if (xhr.status == 200) {
            var equipmentList = document.getElementById('equipment-list');
            if (xhr.responseText.trim() === '') {
                equipmentList.innerHTML = 'No Equipment List!';
            } else {
                equipmentList.innerHTML = xhr.responseText;
            }
        }
    };
    xhr.send();
}

window.onload = function() {
    updateEquipmentList();
    
    fetchLogs('PHP/get_all_logs.php');
};

const buttons1 = document.querySelectorAll('button');

buttons1.forEach(button => {
  button.addEventListener('click', function() {
    updateEquipmentList();
   
  });
});
const alll = document.querySelectorAll('.alll');


alll.forEach(button => {
    button.addEventListener('click', function() {
     
        setTimeout(() => {
            fetchTableData();
            fetchLogs('PHP/get_all_logs.php');
        }, 1000);

  
    });
  });


























// Add new equipment
document.getElementById('addEquipmentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const equipmentName = document.getElementById('newEquipment').value;
    
    if (equipmentName) {
        const formData = new FormData();
        formData.append('action', 'add_equipment');
        formData.append('equipment_name', equipmentName);
        
        fetch('PHP/equipment.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showEquipment();
                error.textContent = `${data.message}`;
                error.style.backgroundColor = 'green'; 
                erroralert.style.display = 'block';

                setTimeout(() => {
                    erroralert.style.display = 'none';
                }, 3000);

                document.getElementById('newEquipment').value = '';
            } else {
                
                error.textContent = `${data.message}`;
                error.style.backgroundColor = '#F44336'; 
                erroralert.style.display = 'block';

                setTimeout(() => {
                    erroralert.style.display = 'none';
                }, 3000);
            }
        })
        .catch(error => {
            error.textContent = `Error: ${error.message}`;
            error.style.backgroundColor = '#F44336'; 
            erroralert.style.display = 'block';

            setTimeout(() => {
                erroralert.style.display = 'none';
            }, 3000);
            console.error('Error:', error);
        });
    }
});




















































// Delete equipment
function deleteEquipment(equipmentId) {
    const formData = new FormData();
    formData.append('action', 'delete_equipment');
    formData.append('equipment_id', equipmentId);
    
    fetch('PHP/equipment.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            showEquipment();
            error.textContent = `Success: ${data.message}`;
            error.style.backgroundColor = '#4CAF50';
            erroralert.style.display = 'block';

            setTimeout(() => {
                erroralert.style.display = 'none';
            }, 3000);
        } else {
            error.textContent = `Error: ${data.message}`;
            error.style.backgroundColor = '#F44336'; 
            erroralert.style.display = 'block';

            setTimeout(() => {
                erroralert.style.display = 'none';
            }, 3000);
        }
    })
    .catch(error => {
        error.textContent = `Error: ${error.message}`;
        error.style.backgroundColor = '#F44336'; 
        erroralert.style.display = 'block';

        setTimeout(() => {
            erroralert.style.display = 'none';
        }, 3000);
        console.error('Error:', error);
    });
}


















































//Fetch Equipment
function showEquipment() {
    const formData = new FormData();
    formData.append('action', 'fetch_equipment');
    
    fetch('PHP/equipment.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const equipmentList = document.getElementById('equipmentList');
            equipmentList.innerHTML = ''; 
            data.equipment.forEach(equipment => {
                const listItem = document.createElement('div');
                listItem.innerHTML = `
                    ${equipment.equipment_name} 
                    <button onclick="deleteEquipment(${equipment.equipment_id})"><ion-icon name="trash-outline"></ion-icon></button>
                `;
                equipmentList.appendChild(listItem);
            });
        } else {
            console.error('Error fetching equipment');
        }
    })
    .catch(error => {
        error.textContent = `Error: ${error.message}`;
        error.style.backgroundColor = '#F44336'; 
        erroralert.style.display = 'block';

        setTimeout(() => {
            erroralert.style.display = 'none';
        }, 3000);
        console.error('Error:', error);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    showEquipment();
});


































//fetch data
function fetchTableData() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'PHP/fetch.php', true);
    xhr.onload = function () {
        if (this.status === 200) {
            const data = JSON.parse(this.responseText);
            const tableBody = document.querySelector('tbody');
            tableBody.innerHTML = ''; 

            const currentDate = new Date(); 

       
            data.sort((a, b) => {
                if (a.Status === 'In' && b.Status !== 'In') {
                    return -1; 
                }
                if (a.Status !== 'In' && b.Status === 'In') {
                    return 1; 
                }
                return 0;
            });

            data.forEach(row => {
                const fullname = `${row.Firstname} ${row.Middlename || ''} ${row.Lastname}`;
                const tr = document.createElement('tr');
                tr.setAttribute('data-member-id', row.Memberid);

                const [year, month, day] = row.Enddate.split('-').map(Number);
                const rowEndDate = new Date(year, month - 1, day); 
                const formattedDate = rowEndDate.toLocaleDateString('en-US', {
                    weekday: 'short',
                    month: 'short',
                    day: 'numeric',
                    year: 'numeric'
                });

                if (rowEndDate <= currentDate && 'Member' === row.Membershiptype) {
                    tr.innerHTML = `
                        <td style="color: red;"><img src="PHP/${row.ProfileImage}" id="images1">  </td>
                        <td>${fullname}</td>
                        <td style="cursor:auto; font-size:12px">${row.Contactnumber}</td>
                        <td style="cursor:auto;">${row.Address}</td>
                        <td style="color: green;">Renew <sup style="color: red;">Membership Expired: ${formattedDate}</sup></td>
                        <td style="color: gray; pointer-events: none;"><s>${row.Status}</s></td>
                        <td style="color: gray; pointer-events: none;"><s>${row.Equipmentname}</s></td>
                    `;
                } else {
                    tr.innerHTML = `
                        <td><img src="PHP/${row.ProfileImage}" id="images1"></td>
                        <td style="position:relative">${fullname}
                            <button id="change1" onclick="openModal(${row.Memberid}, '${row.Firstname}', '${row.Middlename || ''}', 
                            '${row.Lastname}', '${row.Address}', '${row.Contactnumber}')">
                                <ion-icon name="pencil"></ion-icon>
                            </button>
                        </td>
                        <td style="cursor:auto;">${row.Contactnumber}</td>
                        <td style="cursor:auto; font-size:12px">${row.Address}</td>
                        <td>${row.Membershiptype}</td>
                        <td>${row.Status}</td>
                        <td style="
                            pointer-events: ${(row.Equipmentname === 'None' && row.Status === 'Out') || (row.Equipmentname !== 'None' && row.Status !== 'Out')? 'none' : 'auto'}; 
                            color: ${row.Equipmentname === 'None' && row.Status == 'Out' ? 'gray' : '#03997d'}; 
                            cursor: ${row.Equipmentname === 'None' && row.Status == 'Out' ? 'default' : 'pointer'}; ">
                            ${row.Equipmentname}
                        </td>
                    `;
                }
                
                tableBody.appendChild(tr);

                const statusCells = document.querySelectorAll("tbody tr td:nth-child(6)");
                const registerCells = document.querySelectorAll("tbody tr td:nth-child(5)");

                statusCells.forEach((cell) => {
                    let valu1 = cell.textContent.trim();
                    if (valu1 === 'In') {
                        cell.style.color = 'green';
                    } 
                    else if (valu1 === 'Out') {
                        cell.style.color = 'red';
                    }
                });

                registerCells.forEach((cell) => {
                    let valu1 = cell.textContent.trim();
                    if (valu1 == 'Member') {
                        cell.style.color = '#5A9BD4';
                    } 
                    else if (valu1 == 'Session') {
                        cell.style.color = '#2ECC71';
                    }
                });
            });

            const noResults = document.getElementById('no-results');
            if (data.length === 0) {
                noResults.style.display = 'block';
            } else {
                noResults.style.display = 'none';
            }

            attachModalListeners();
        }
    };
    xhr.send();
}


















//modal member details edit

function openModal(memberid, firstname, middlename, lastname, address, contactnumber) {
    document.getElementById('memberid').value = memberid;
    document.getElementById('firstname').value = firstname;
    document.getElementById('middlename').value = middlename;
    document.getElementById('lastname').value = lastname;
    document.getElementById('address1').value = address;
    document.getElementById('contact').value = contactnumber;

    document.getElementById('editModal').style.display = "block";
}
function closeModal() {
    document.getElementById('editModal').style.display = "none";
}

function saveChanges() {
    const memberId = document.getElementById('memberid').value;
    const firstName = document.getElementById('firstname').value;
    const middleName = document.getElementById('middlename').value;
    const lastName = document.getElementById('lastname').value;
    
    const address = document.getElementById('address1').value;
    const contactNumber = document.getElementById('contact').value;

    const formData = new FormData();
    formData.append('member_id', memberId);
    formData.append('firstName', firstName);
    formData.append('middleName', middleName);
    formData.append('lastName', lastName);
    
    formData.append('address', address);
    formData.append('contactNumber', contactNumber);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'PHP/update_member.php', true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = xhr.responseText;

            if (response.includes("successfully")) {
            
                error.style.backgroundColor = 'green';
                error.textContent = 'Member updated successfully!';
                erroralert.style.display = 'block';

                setTimeout(() => {
                    erroralert.style.display = 'none';
                }, 3000);

                closeModal();  
            } else {
                error.style.backgroundColor = '#F44336';
                error.textContent = 'Error updating member.';
                erroralert.style.display = 'block';

                setTimeout(() => {
                    erroralert.style.display = 'none';
                }, 3000);
            }
        } else {
            error.style.backgroundColor = '#F44336';
            error.textContent = 'An error occurred. Please try again.';
            erroralert.style.display = 'block';

            setTimeout(() => {
                erroralert.style.display = 'none';
            }, 3000);
        }
    };

    xhr.send(formData);
}

window.onclick = function(event) {
    if (event.target == document.getElementById('editModal')) {
        closeModal();
    }
} 





























//biggermodal
function attachModalListeners() {
    const tableImages = document.querySelectorAll('tbody img');
    const modal = document.getElementById('modal-biggerimg');
    const modalImage = modal.querySelector('img');
    const closeModalButton = document.getElementById('exit12');

    tableImages.forEach(img => {
        img.addEventListener('click', () => {
            const imageUrl = img.getAttribute('src');
            modalImage.setAttribute('src', imageUrl);
            modal.style.display = 'block';
        });
    });

    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });





























    // Rent Modal
    const modalRent = document.querySelector("#modal-rent");
    const rentCells = document.querySelectorAll("tbody tr td:nth-child(7)");
    
    rentCells.forEach((cell) => {
        cell.addEventListener("click", function () {
            const row = this.closest('tr');
            const memberId = row.getAttribute('data-member-id');
            const cellContent = this.textContent.trim();
            if (cellContent !== 'None') {
                return; 
            }
    
            if (memberId && memberId !== 'None') {
                document.querySelector("#rent-member-id").value = memberId;
                modalRent.style.display = "block";
            }
        });
    });
    
    const closeRentBtn = modalRent.querySelector(".close");
    closeRentBtn.addEventListener("click", () => {
        modalRent.style.display = "none";
    });
    












    // Status Modal
    const modalStatus = document.querySelector("#modal-status");
    const statusCells = document.querySelectorAll("tbody tr td:nth-child(6)");

    statusCells.forEach((cell) => {
        cell.addEventListener("click", function () {
            const row = this.closest('tr');
            const memberId = row.getAttribute('data-member-id');
            document.querySelector("#status-member-id").value = memberId;

            if (this.textContent.trim() === "In") {
                document.querySelector(".In").checked = true;
            } else {
                document.querySelector(".Out").checked = true;
            }

            modalStatus.style.display = "block";
        });
    });

    document.querySelector('#exit-status').addEventListener("click", () => {
        modalStatus.style.display = "none";
    });


























    // Register Modal
    const modalRegister = document.querySelector("#modal-register");
    const registerCells = document.querySelectorAll("tbody tr td:nth-child(5)");

    registerCells.forEach((cell) => {
        cell.addEventListener("click", function (event) {
            const row = this.closest('tr');
            const memberId = row.getAttribute('data-member-id');
            document.querySelector("#register-member-id").value = memberId;

            const status = this.textContent.trim();
            if (status === "Member") {
                document.querySelector(".Member").checked = true;
            } else if (status === "Session") {
                document.querySelector(".Session").checked = true;
            }

            modalRegister.style.display = "block";
            event.stopPropagation();
        });
    });

    const closeRegisterBtn = modalRegister.querySelector(".close");
    closeRegisterBtn.addEventListener("click", () => {
        modalRegister.style.display = "none";
        document.querySelector(".Member").checked = false;
        document.querySelector(".Session").checked = false;
    });
}

document.querySelectorAll('.submitting').forEach(function (element) {
    element.addEventListener('click', function () {
        setTimeout(() => {
            fetchTableData(); 
        }, 1000);
    });
});

document.addEventListener('DOMContentLoaded', fetchTableData);






















//Form Register
document.getElementById("submitButton").addEventListener("click", function () {

    const requiredFields = [
        { id: "firstName", name: "First Name" },
        { id: "middleName", name: "Middle Name" },
        { id: "lastName", name: "Last Name" },
        { id: "contactNumber", name: "Contact Number" },
        { id: "address", name: "Address" },
        { id: "registerType", name: "Register Type" },
        { id: "start-member", name: "startmember" },
        { id: "end-member", name: "endmember" },
        { id: "member-img", name: "Member Image", type: "file" }
    ];

    let isValid = true;

    for (let field of requiredFields) {
        const input = document.getElementById(field.id);
        if (field.type === "file") {
            if (!input.files || !input.files[0]) {
                error.textContent = `Please upload a ${field.name}.`;
                error.style.backgroundColor = '#F44336';
                erroralert.style.display = 'block';
                setTimeout(() => {
                    erroralert.style.display = 'none';
                }, 3000);
                isValid = false;
                break;
            }
        } else if (!input.value.trim()) {
            error.textContent = `Please fill out the ${field.name}.`;
            error.style.backgroundColor = '#F44336';
            erroralert.style.display = 'block';
            setTimeout(() => {
                erroralert.style.display = 'none';
            }, 3000);
            isValid = false;
            break;
        }
    }

    const registerType = document.getElementById("registerType");
    if (!registerType.value || registerType.selectedIndex === 0) {
        error.textContent = 'Please select a valid registration type.';
        error.style.backgroundColor = '#F44336';
        erroralert.style.display = 'block';
        setTimeout(() => {
            erroralert.style.display = 'none';
        }, 3000);
        isValid = false;
        return;
    }

    if (!isValid) {
        return;
    }

    const firstName = document.getElementById("firstName").value;
    const middleName = document.getElementById("middleName").value;
    const lastName = document.getElementById("lastName").value;

    const xhrCheck = new XMLHttpRequest();
    xhrCheck.open("POST", "PHP/checkExistingMember.php", true);
    xhrCheck.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhrCheck.onload = function () {
        if (xhrCheck.status === 200) {
            const response = xhrCheck.responseText.trim();

            if (response === "exists") {
                error.textContent = "Person Already Exist!";
                error.style.backgroundColor = '#F44336';
                erroralert.style.display = 'block';
                setTimeout(() => {
                    erroralert.style.display = 'none';
                }, 3000);
            } else {
                const formData = new FormData();
                formData.append("firstName", firstName);
                formData.append("middleName", middleName);
                formData.append("lastName", lastName);
                formData.append("contactNumber", document.getElementById("contactNumber").value);
                formData.append("address", document.getElementById("address").value);
                formData.append("registerType", document.getElementById("registerType").value);
                formData.append("memberImg", document.getElementById("member-img").files[0]);
                formData.append("startmember", document.getElementById("start-member").value);
                formData.append("endmember", document.getElementById("end-member").value);

                const xhr = new XMLHttpRequest();
                xhr.open("POST", "PHP/member.php", true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        error.textContent = xhr.responseText;
                        error.style.backgroundColor = 'green';
                        document.getElementById("firstName").value = '';
                        document.getElementById("middleName").value = '';
                        document.getElementById("lastName").value = '';
                        document.getElementById("contactNumber").value = '';
                        document.getElementById("address").value = '';
                        
                      
                        document.getElementById("registerType").selectedIndex = 0; 

                        const imgPreview = document.getElementById('image-member');
                        imgPreview.src = 'src/logo.jpg'; 
                        document.getElementById("member-img").files[0] = '';
                        var modals = document.querySelectorAll('.modal');
                        modals.forEach(function(modal) {
                            modal.style.display = 'none';
                        });
                    } else {
                        error.textContent = "An error occurred: " + xhr.responseText;
                        error.style.backgroundColor = '#F44336';
                    }

                    erroralert.style.display = 'block';
                    setTimeout(() => {
                        erroralert.style.display = 'none';
                    }, 3000);
                };
                xhr.send(formData);
            }
        } else {
            error.textContent = "An error occurred while checking for existing members.";
            error.style.backgroundColor = '#F44336';
            erroralert.style.display = 'block';
            setTimeout(() => {
                erroralert.style.display = 'none';
            }, 3000);
        }
    };

    xhrCheck.send(`firstName=${firstName}&middleName=${middleName}&lastName=${lastName}`);
});







































//form register
document.querySelector('.form-register').addEventListener('submit', function (e) {
    e.preventDefault(); 

    const formData = new FormData(this);  
    const status = document.querySelector('input[name="Register"]:checked')?.value; 
    const memberId = document.querySelector('#register-member-id').value;

    let startDate = new Date();
    let endDate = new Date(startDate);
    endDate.setDate(startDate.getDate() + 30);

    formData.append("start_date", startDate.toISOString().split("T")[0]);
    formData.append("end_date", endDate.toISOString().split("T")[0]);

    if (!status) { 
        error.textContent = "Please select a status!";
        error.style.backgroundColor = '#F44336';
        erroralert.style.display = 'block';
        setTimeout(() => {
            erroralert.style.display = 'none';
        }, 3000);
        return;
    }

    formData.append("register_type", status);  
    formData.append("member_id", memberId);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'PHP/registertype.php', true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            error.textContent = xhr.responseText;
            error.style.backgroundColor = 'green';
            var modals = document.querySelectorAll('.modal');
            modals.forEach(function(modal) {
                modal.style.display = 'none';
            });
        } else {
            error.textContent = "An error occurred: " + xhr.responseText;
            error.style.backgroundColor = '#F44336';
        }

        erroralert.style.display = 'block';
        setTimeout(() => {
            erroralert.style.display = 'none';
        }, 3000);
    };

    xhr.send(formData);  
});

























// form status
document.querySelector('.form-status').addEventListener('submit', function (e) {
    e.preventDefault();
  const formData = new FormData(this);
    const status = document.querySelector('input[name="status"]:checked')?.value;
    const memberId = document.querySelector('#status-member-id').value;

    if (!status) {
        error.textContent = "Please select a status!";
        error.style.backgroundColor = '#F44336';
        erroralert.style.display = 'block';
        setTimeout(() => {
            erroralert.style.display = 'none';
        }, 3000);
        return;
    }

    formData.append("status", status);
    formData.append("member_id", memberId);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'PHP/status.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (xhr.status === 200) {
            error.textContent = xhr.responseText;
            error.style.backgroundColor = 'green';
            var modals = document.querySelectorAll('.modal');
            modals.forEach(function(modal) {
                modal.style.display = 'none';
            });
        } else {
            error.textContent = "An error occurred: " + xhr.responseText;
            error.style.backgroundColor = '#F44336';
        }

        erroralert.style.display = 'block';

        setTimeout(() => {
            erroralert.style.display = 'none';
        }, 3000);
    };

    xhr.send(new URLSearchParams(formData).toString());
});
































//form rent


document.querySelector('.form-rent').addEventListener('submit', function (e) {
    e.preventDefault(); 

    const formData = new FormData(this);  
    const memberId = document.querySelector('#rent-member-id').value;

    const rentedEquipment = [];
    document.querySelectorAll('.form-rent input[type="checkbox"]:checked').forEach((checkbox) => {
        rentedEquipment.push(checkbox.value);
    });

    if (rentedEquipment.length === 0) {
        error.textContent = "Please select at least one piece of equipment!";
        error.style.backgroundColor = '#F44336';
        erroralert.style.display = 'block';
        setTimeout(() => {
            erroralert.style.display = 'none';
        }, 3000);
        return;
    }

    const rentedEquipmentString = rentedEquipment.join(',');  

    formData.set("member_id", memberId);
    formData.set("equipment", rentedEquipmentString); 

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'PHP/rent_equipment.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (xhr.status === 200) {

            const response = JSON.parse(xhr.responseText);
            error.textContent = response.status === 'success' ? 'Rental successful!' : 'An error occurred';
            error.style.backgroundColor = response.status === 'success' ? 'green' : '#F44336';
            
         
            const equipmentName = response.equipmentName;  
            if (equipmentName && equipmentName !== 'None') {
          
              
            }
            var modals = document.querySelectorAll('.modal');
            modals.forEach(function(modal) {
                modal.style.display = 'none';
            });

        } else {
            error.textContent = "An error occurred: " + xhr.responseText;
            error.style.backgroundColor = '#F44336';
        }

        erroralert.style.display = 'block';
        setTimeout(() => {
            erroralert.style.display = 'none';
        }, 3000);
    };

    xhr.send(new URLSearchParams(formData).toString()); 
});









document.addEventListener('DOMContentLoaded', () => {
   
    fetchLogs('PHP/get_all_logs.php');
});


function handleLogSelection(type) {
    if (type === 'rent') {
        fetchLogs('PHP/get_equipment_logs.php');
    } else if (type === 'status') {
        fetchLogs('PHP/get_status_logs.php');
    } else if (type === 'all') {
        fetchLogs('PHP/get_all_logs.php'); 
    }
}

function formatDateTime(dateString) {
    const date = new Date(dateString);

    const formattedDate = date.toISOString().split('T')[0]; 

    const options = { hour: 'numeric', minute: 'numeric', hour12: true };
    const time = date.toLocaleTimeString('en-US', options);

    return `${formattedDate} ${time}`;
}function fetchLogs(endpoint) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', endpoint, true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            const tableBody = document.getElementById('logs-table-body');
            tableBody.innerHTML = '';

            if (data.length > 0) {
                data.forEach((log, index) => {
                    let color = ''; 

                    if (log.activity_or_equipment === 'In') {
                        color = 'green';
                    } else if (log.activity_or_equipment === 'Out') {
                        color = 'red';
                    }
                    else{
                       
                       color = '#03997d';
                    }

                    const row = document.createElement('tr');
                    row.innerHTML = `
                     
                        <td><img src="PHP/${log.image}" alt="Profile Image" width="50" height="50"></td>
                        <td>${log.name}</td>
                        <td style="cursor:auto;">${log.Contact}</td>
                        <td style="cursor:auto; font-size:12px;">${log.Address}</td>
                        <td style="cursor:auto; color: ${color}">
                            ${log.activity_or_equipment}
                        </td>
                        <td style="cursor:auto;">${formatDateTime(log.date)}</td>
                    `;
                    tableBody.appendChild(row);
                });
                document.getElementById('no-results').style.display = 'none'; 
            } else {
                document.getElementById('no-results').style.display = 'block';
            }
        }
    };
    xhr.send();
}

































//change password
document.getElementById('change-password-form').addEventListener('submit', function (e) {
    e.preventDefault();

    const currentPassword = document.getElementById('current-password').value;
    const newPassword = document.getElementById('new-password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    const email = document.getElementById('email').value; 
    const errorAlert = document.getElementById('error-alert1');
    const error = document.getElementById('error1');

    if (!currentPassword) {
        error.textContent = "Please enter your correct current password!";
        error.style.backgroundColor = '#F44336';  
        errorAlert.style.display = 'block';
        setTimeout(() => {
            errorAlert.style.display = 'none';
        }, 3000);
        return;
    }

    if (newPassword !== confirmPassword) {
        error.textContent = "New password and confirm password do not match!";
        error.style.backgroundColor = '#F44336'; 
        errorAlert.style.display = 'block';
        setTimeout(() => {
            errorAlert.style.display = 'none';
        }, 3000);
        return;
    }

    const formData = new FormData();
    formData.append('username', document.getElementById('username').value);
    formData.append('email', email);
    formData.append('current_password', currentPassword);
    formData.append('new_password', newPassword);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'PHP/change_password.php', true);
    
    xhr.onload = function () {
        const response = JSON.parse(xhr.responseText);
        
        if (response.success) {
            error.textContent = response.message;
            error.style.backgroundColor = 'green'; 
            errorAlert.style.display = 'block';
            setTimeout(() => {
                errorAlert.style.display = 'none';
                document.getElementById('current-password').value = '';
                document.getElementById('new-password').value = '';
                document.getElementById('confirm-password').value = '';
            }, 3000);
        } else {
            error.textContent = response.message;
            error.style.backgroundColor = '#F44336'; 
            errorAlert.style.display = 'block';
            setTimeout(() => {
                errorAlert.style.display = 'none';
            }, 3000);
        }
    };

    xhr.send(formData);
});


function updateCounts() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'PHP/count.php', true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            var data = JSON.parse(xhr.responseText);

            document.querySelector('.numbers.member').textContent = data.member_count;
            document.querySelector('.numbers.session').textContent = data.session_count;
        }
    };

    xhr.send();
}

updateCounts();

setInterval(updateCounts, 5000);


const errorAlert2 = document.getElementById('error-alert2');
const errorMessage2 = document.getElementById('error2');

document.getElementById('logout').addEventListener('click', function() {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'PHP/logout.php', true);
    xhr.onload = function() {
        if (xhr.status === 200 && xhr.responseText === 'success') {
            var modals = document.querySelectorAll('.modal');
            modals.forEach(function(modal) {
                modal.style.display = 'none';
            });
            showMessage('Signing out...', 'success');
            setTimeout(() => window.location.href = 'index.php', 3000); 
        } else {
            showMessage('Error signing out. Try again.', 'error');
        }
    };
    xhr.send(); 
});















function showMessage(message, type) {
    errorMessage2.textContent = message;
    errorMessage2.style.backgroundColor = (type === 'success') ? 'green' : '#F44336';
    errorAlert2.style.display = 'block';
    setTimeout(() => errorAlert2.style.display = 'none', 3000);
}

function validateContact(input) {
    input.value = input.value.replace(/\D/g, '');
    if (!input.value.startsWith('09')) {
        input.value = '09';
    }
    if (input.value.length > 11) {
        input.value = input.value.slice(0, 11);
    }
}





function deleteOldMembers() {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "PHP/delete_old_members.php", true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log(xhr.responseText);
        } else {
            console.error("Failed to delete old members.");
        }
    };

    xhr.send();
}

document.addEventListener("DOMContentLoaded", () => {
    deleteOldMembers();
});

setInterval(deleteOldMembers, 24 * 60 * 60 * 1000);















