document.getElementById('login-form').addEventListener('submit', function (e) {
    e.preventDefault();  // Prevent form submission

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const errorMessage = document.getElementById('error');
    const erroralert = document.getElementById('erroralert');

    const formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'PHP/login.php', true);
    xhr.onload = function () {
        const response = JSON.parse(xhr.responseText);

     
        if (response.success) {
            errorMessage.textContent = 'Successfully logged in. Redirecting...';
            errorMessage.style.backgroundColor = 'green'; 
            erroralert.style.display = 'block'; 
            
            setTimeout(() => {
                erroralert.style.display = 'none';  
                window.location.href = 'dashboard.php';  
            }, 3000);
        } else {
            errorMessage.textContent = response.message;
            errorMessage.style.backgroundColor = '#F44336';
            erroralert.style.display = 'block'; 
            setTimeout(() => {
                erroralert.style.display = 'none';  
            }, 3000);
        }
    };

    xhr.send(formData);
});
