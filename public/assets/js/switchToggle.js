window.onload = () => {
  let activate = document.querySelectorAll("[type=checkbox]")             // Je declare la checkbox
  for (let button of activate){
    button.addEventListener("click", function (){                     // je crée l'événement pour activer ou désactiver apres le click
      let xmlhttp = new XMLHttpRequest;

      xmlhttp.open("get", `/franchises/activer/${this.dataset.id}`)    // je cherche l'id de la franchise
      xmlhttp.send()
    })
  }
}