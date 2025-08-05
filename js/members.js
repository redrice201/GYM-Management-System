//members date

window.addEventListener("load", function () {
    let start = document.getElementById("start-member");
   
    let end = document.getElementById("end-member");
  
    let startDate = new Date();
  
    start.value = startDate.toISOString().split("T")[0];
    
  
    let endDate = new Date(startDate);
    endDate.setDate(startDate.getDate() + 30);
  
    end.value = endDate.toISOString().split("T")[0];
  });
  


document.getElementById("image-member").addEventListener("click", function () {
    document.getElementById("member-img").click();
  });



function Images(event) {
  const file = event.target.files[0];
  if (file) {
      const imgPreview = document.getElementById('image-member');
      imgPreview.src = URL.createObjectURL(file); 
      imgPreview.onload = () => URL.revokeObjectURL(imgPreview.src); 
  }
}




document.getElementById("addmember").addEventListener("click", function () {
  let modalmember = document.getElementById('modal-member');


  modalmember.style.display = 'block';
});



document.getElementById("exit").addEventListener('click', function () {
  let modalmember = document.getElementById('modal-member');
  
  modalmember.style.display = 'none';
  
});



document.getElementById("exit12").addEventListener('click', function () {
  let modalmember = document.getElementById('modal-biggerimg');
  
  modalmember.style.display = 'none';
  
});




document.getElementById('rentequipment').onclick = () => {
  document.getElementById('modal-equipment').style.display = 'block';
};

document.getElementById('close-modal').onclick = () => {
  document.getElementById('modal-equipment').style.display = 'none';
};