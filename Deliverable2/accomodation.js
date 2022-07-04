function openForm(){
    document.getElementById("myForm").style.display = "block";
    document.querySelector(".offer").style.filter="blur(2px)";
     document.getElementById("myForm").style.filter = "none";
}

function closeForm(){
    document.getElementById("myForm").style.display ="none";
    document.querySelector(".offer").style.filter="none";
}


