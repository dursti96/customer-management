document.getElementsByClassName("buttonEdit").addEventListener("click", showform())


function showform(){
    var contactperson = this.getAttribute("data-id");
    document.getElementsByClassName("formedit").style.display = unset;
};


