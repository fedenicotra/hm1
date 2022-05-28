let usrOK = false;
function onResponse(data){
	return data.json();
}

function containsMarks(password){
    for(let mark of marks){
        if(password.includes(mark)) return true;
    }
    return false;
}

function checkPassword(){
    if(pwdtxt.value == ""){
        pwdtxt.style.border = "";
        return false;
    }
    if(pwdtxt.value.length < 8 || !containsMarks(pwdtxt.value)){
        pwdtxt.style.border = "var(--red_error) groove 3px";
        return false;
    }
    else{
        pwdtxt.style.border = "var(--primary_color_light) groove 3px";
        return true;
    }
}

function validateForm(event){
    if(form.email.value.length == 0 || form.pwd.value.length == 0 || form.pwd_v.value.length == 0 || form.username.value.length == 0){
        alert("Compilare tutti i campi");
        event.preventDefault();
    }
    else if(form.pwd.value != form.pwd_v.value){
        alert("Le password non corrispondono");
        event.preventDefault();
    }
    else if(form.pwd.value.length < 8){
        alert("La password deve essere di almeno 8 caratteri");
        event.preventDefault();
    }
    else if(!containsMarks(form.pwd.value)){
        alert("La password deve contenere almeno un carattere speciale");
        event.preventDefault();
    }
}

function checkUsername(event){
    const username = encodeURIComponent(usertxt.value);
    if(usertxt.value == ""){
        usertxt.style.border = "";
        const notvalid = document.querySelector("#notvalid");
        if(notvalid) notvalid.remove();
        return;
    }
    fetch("http://192.168.1.137/hm1/api_db/checkUsername.php?username=" + username)
    .then(onResponse)
    .then(data => {

				const notvalid = document.querySelector("#notvalid");
				if(notvalid) notvalid.remove();
        if(data[0] === undefined){
            usertxt.style.border = "var(--primary_color_light) groove 3px";
            usrOK = true;
        }
        else{
            usertxt.style.border = "var(--red_error) groove 3px";
            usrOK = false;
            const notvalid = document.createElement("span");
            notvalid.textContent="Username già in uso";
            notvalid.id="notvalid";
            notvalid.style.color = "var(--red_error)";
            usertxt.parentNode.appendChild(notvalid);
        }
    })
}

function checkPasswordCheck(event){
    if(pwdtxt.value == pwdvtxt.value){
        pwdvtxt.style.border = "var(--primary_color_light) groove 3px";
        return true;
    }
    else{
        pwdvtxt.style.border = "";
        return false;
    }
}

function checkEmail(event){
    if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(etxt.value)){
        etxt.style.border = "var(--primary_color_light) groove 3px";
        return true;
    }
    else{
        etxt.style.border = "";
        return false;
    }
}

const marks = new Array('[',']','(',')','@','*','&','£','!','#','?','%','$','=',"'",'^');
const form = document.forms['signup'];
const usertxt = document.querySelector("#username");
const pwdtxt = document.querySelector("#pwd");
const etxt = document.querySelector("#emailtext");
const pwdvtxt = document.querySelector("#pwd_v");

form.addEventListener('submit', validateForm);
usertxt.addEventListener('keyup', checkUsername);
pwdtxt.addEventListener('keyup', checkPassword);
pwdvtxt.addEventListener('keyup', checkPasswordCheck);
etxt.addEventListener('keyup', checkEmail);
etxt.addEventListener('change', checkEmail);
etxt.addEventListener('click', checkEmail);
