var signup_form = document.forms["credentials"];
var firstname = signup_form["name"];
var surname = signup_form["surname"];
var username = signup_form["username"];
var email = signup_form["email"];
var password = signup_form["password"];
var confirm_password = signup_form["confirm_password"];


function checkName(event) {

    if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(firstname.value)){
        document.querySelector("#name_err").classList.add("errorj");
        document.querySelector("#name_err span").textContent = "Formato nome invalido";
    }
    else document.querySelector("#name_err").classList.remove("errorj");
}

function checkSurname(event) {

    if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(surname.value)){
        document.querySelector("#surname_err").classList.add("errorj");
        document.querySelector("#surname_err span").textContent = "Formato cognome invalido";
    }
    else document.querySelector("#surname_err").classList.remove("errorj");
}

function checkUsername(event) {

    if (!/^[a-zA-ZÀ-ÿ\s]+$/.test(username.value)){
        document.querySelector("#username_err").classList.add("errorj");
        document.querySelector("#username_err span").textContent = "Formato Username invalido";
    }
    else fetch("./assets/check_username.php?q=" + encodeURIComponent(username.value))
    .then((res) =>{
        return res.json();
    })
    .then((json) => {
        if (json.exists){
            document.querySelector("#username_err").classList.add("errorj");
            document.querySelector("#username_err span").textContent = "Username già preso!"
        }
        else document.querySelector("#username_err").classList.remove("errorj");

    })
}

function checkEmail(event) {

    if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email.value)){
        document.querySelector("#email_err").classList.add("errorj");
        document.querySelector("#email_err span").textContent = "Formato e-mail invalido";
    }
    else fetch("./assets/check_email.php?q=" + encodeURIComponent(email.value))
    .then((res) =>{
        return res.json();
    })
    .then((json) => {
        if(json.exists){
            document.querySelector("#email_err").classList.add("errorj");
            document.querySelector("#email_err span").textContent = "e-mail già registrata!";
        }
        else document.querySelector("#email_err").classList.remove("errorj");
    })
}

function checkPassword(event) {
    if (!/^(?=.*[A-Z])(?=.*[0-9]).{8,}$/.test(password.value)) {
        document.querySelector("#password_err").classList.add("errorj");
        document.querySelector("#password_err span").textContent = "Password min. 8 caratteri, che contenga almeno una maiuscola e un numero"
    }
    else document.querySelector("#password_err").classList.remove("errorj");
}

function CheckConfirmPassword(event) {
    if (password.value === confirm_password.value) {
        document.querySelector("#confirm_err").classList.remove("errorj");
    }
    else {document.querySelector("#confirm_err").classList.add("errorj");
        document.querySelector("#confirm_err span").textContent = "Le password non coincidono";
    }
}



function onSubmit(event) {
    const errors = document.querySelectorAll(".errorj");
  
    errors = document.querySelectorAll(".errorj");
    if (errors.length > 0) {
      event.preventDefault();
      return;
    }
    checkEmail();
    checkName();
    checkSurname();
    checkUsername();
    checkPassword();
    
    errors = document.querySelectorAll(".errorjs");
    if (errors.length > 0) {
        event.preventDefault();
     }
    
}


document.querySelector('.name input').addEventListener('blur', checkName);
document.querySelector('.surname input').addEventListener('blur', checkSurname);
document.querySelector('.username input').addEventListener('blur', checkUsername);
document.querySelector('.email input').addEventListener('blur', checkEmail);
document.querySelector('.password input').addEventListener('blur', checkPassword);
document.querySelector('.confirm_password input').addEventListener('blur', CheckConfirmPassword);
document.querySelector('.submit_btn').addEventListener('click', onSubmit);