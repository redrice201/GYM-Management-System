

window.addEventListener("load", function () {
    let radioIn = document.querySelectorAll(".In");
    let radioOut = document.querySelectorAll(".Out");

    let Session = document.querySelectorAll(".Session");
    let Member = document.querySelectorAll(".Member");

 const statusCells = document.querySelectorAll("tbody tr td:nth-child(6)");
 const registerCells = document.querySelectorAll("tbody tr td:nth-child(5)");
    statusCells.forEach((cell) => {
        let valu1 = cell.textContent.trim();
        if(valu1 == 'In'){
            cell.style.color = 'Green';
        }
        else{
            cell.style.color = 'Red';
        }
     
    });
    registerCells.forEach((cell) => {
        let valu1 = cell.textContent.trim();
        if(valu1 == 'Member'){
            cell.style.color = '#5A9BD4';
        }
        else{
            cell.style.color = '#2ECC71';
        }
     
    });
});

//search filter for table


function filterTable(type) {
    const searchValue = document.querySelector('.search input').value.trim().toLowerCase();
    const selectedLog = document.querySelector('.log').value;
    const rows = document.querySelectorAll('tbody tr');
    let hasResults = false;

    rows.forEach(row => {
        const nameText = row.cells[1].textContent.trim().toLowerCase();
        const typeText = row.cells[4].textContent.trim(); 
        const statusText = row.cells[5].textContent.trim(); 

        const matchesType = type === 'All' || typeText === type;
        const matchesStatus = selectedLog === 'All' || statusText === selectedLog;
        const matchesSearch = nameText.includes(searchValue);
        if (matchesType && matchesStatus && matchesSearch) {
            row.style.display = '';
            hasResults = true;
        } else {
            row.style.display = 'none';
        }
    });

    const noResultsMessages = document.querySelectorAll('#no-results');
    noResultsMessages.forEach((noResultsMessage) => {
        if (!hasResults) {
            noResultsMessage.style.display = 'block';
        } else {
            noResultsMessage.style.display = 'none';
        }
    });
}

document.querySelector('.log').addEventListener('change', () => filterTable('All'));









//Animation
function fadeOut(element, callback) {
    element.style.opacity = 1;
    element.style.transition = 'opacity 0.2s';
    element.style.opacity = 0;
    setTimeout(() => {
        element.style.display = 'none';
        if (callback) callback();
    }, 500);
}

function fadeIn(element) {
    element.style.display = 'block';
    element.style.opacity = 0;
    element.style.transition = 'opacity 0.2s';
    setTimeout(() => {
        element.style.opacity = 1;
    }, 10); 
}

document.getElementById('dashboard').addEventListener('click', function () {
    let dashboardbody = document.getElementById('dashboard-body');
    let customerbody = document.getElementById('customer-body');
    let searchbar = document.getElementById('searches');
    let password = document.getElementById('password-body');
    let logsbody = document.getElementById('logs-body');

    fadeOut(searchbar);
    fadeOut(customerbody);
    fadeOut(password);
    fadeOut(logsbody, () => fadeIn(dashboardbody));
});

document.getElementById('membersession').addEventListener('click', function () {
    let dashboardbody = document.getElementById('dashboard-body');
    let customerbody = document.getElementById('customer-body');
    let searchbar = document.getElementById('searches');
    let password = document.getElementById('password-body');
    let logsbody = document.getElementById('logs-body');

    fadeOut(dashboardbody);
    fadeOut(password);
    fadeOut(logsbody, () => {
        fadeIn(searchbar);
        fadeIn(customerbody);
    });
});

document.getElementById('password-sidebar').addEventListener('click', function () {
    let dashboardbody = document.getElementById('dashboard-body');
    let customerbody = document.getElementById('customer-body');
    let searchbar = document.getElementById('searches');
    let password = document.getElementById('password-body');
    let logsbody = document.getElementById('logs-body');

    fadeOut(dashboardbody);
    fadeOut(customerbody);
    fadeOut(searchbar);
    fadeOut(logsbody, () => fadeIn(password));
});

document.getElementById('logs-sidebar').addEventListener('click', function () {
    let dashboardbody = document.getElementById('dashboard-body');
    let customerbody = document.getElementById('customer-body');
    let searchbar = document.getElementById('searches');
    let password = document.getElementById('password-body');
    let logsbody = document.getElementById('logs-body');

    fadeOut(dashboardbody);
    fadeOut(customerbody);
    fadeOut(password, () => {
        fadeIn(searchbar);
        fadeIn(logsbody);
    });
});
