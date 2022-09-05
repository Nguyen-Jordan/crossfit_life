// Transition d'apparition du formulaire login
const bodyLogin = document.querySelector('#bodyLogin');
bodyLogin.classList.remove('opacity0');
bodyLogin.classList.add('opacity1');

// Animation des transitions email
function  layoutIni() {
    const divEmail = document.querySelector("#divEmail");
    divEmail.classList.add('layoutActive');
}

setTimeout(layoutIni,500);

// On donne les valeurs aux boutons
document.querySelector("#btnNextPass").onclick = function(){
    const emailUser = document.querySelector("#emailUser").value;
    const alertEmailLogin = document.querySelector("#alertEmailLogin");
    const spanEmail = document.querySelector("#spanEmail");
    const emailValid = fntEmailValidate(emailUser);

// On crée un message alert si l'email n'est pas valide
    if(!emailValid){
        alertEmailLogin.innerHTML = '<p style="color:red;">Entrez une adresse e-mail valide.</p>';
        alertEmailLogin.style.display = "block";
    } else{
        alertEmailLogin.style.display = "none";
        spanEmail.innerHTML = emailUser;
        nextLayout('#divEmail', '#divPassword');
    }
}

// On crée une alert de verification instantanée
document.querySelector("#emailUser").onkeyup = function(){
    const emailUser = document.querySelector("#emailUser").value;
    const alertEmailLogin = document.querySelector("#alertEmailLogin");
    const emailValid = fntEmailValidate(emailUser);

    if(!emailValid){
        alertEmailLogin.innerHTML = '<p style="color:red;">Entrez une adresse e-mail valide.</p>';
        alertEmailLogin.style.display = 'block';
    } else{
        alertEmailLogin.style.display = "none";
    }
}

document.querySelector("#btnPrev").onclick = function(){
    prevLayout("#divPassword","#divEmail");
}

// On crée un message alert si le password n'est pas valide
document.querySelector("#btnLogin").onclick = function(){
    const strEmailUser = document.querySelector("#emailUser").value;
    const strPassUser = document.querySelector("#passUser").value;

    const alertPass = document.querySelector("#alertPass");

    if(strPassUser === "")
    {
        alertPass.innerHTML = '<p style="color:red;">Entrez votre mot de passe.</p>';
        alertPass.style.display = 'block';
    } else{
        alertPass.style.display = "none";
    }

}

// On paramètre les apparitions
function nextLayout(parent,next) {
    const divParent = document.querySelector(parent);
    const divNext = document.querySelector(next);
    divParent.classList.remove('layoutLeft', 'layoutRight', 'layoutActive');
    divNext.classList.remove('layoutLeft', 'layoutRight', 'layoutActive');

    // Transition de positionnement
    divParent.classList.toggle('layoutLeft');
    divNext.classList.toggle('layoutActive');
}

// On paramètre retour en arriere
function prevLayout(parent,prev) {
    const divParent = document.querySelector(parent);
    const divPrev = document.querySelector(prev);
    divParent.classList.remove('layoutLeft', 'layoutRight', 'layoutActive');
    divPrev.classList.remove('layoutLeft', 'layoutRight', 'layoutActive');

    // Transition de positionnement
    divParent.classList.toggle('layoutRight');
    divPrev.classList.toggle('layoutActive');
}

// On valide format l'email
function fntEmailValidate(email){
    const stringEmail = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
    if(stringEmail.test(email) === false) {
        return false;
    } else{
        return true;
    }
}

