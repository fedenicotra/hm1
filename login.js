function validateForm(event){
    if(form.email.value.length == 0 || form.pwd.value.length == 0 ){
        alert("Compilare tutti i campi");
        event.preventDefault();
    }
}

const form = document.forms['loginform'];
form.addEventListener('submit',validateForm);