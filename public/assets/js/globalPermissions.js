let collection, boutonAjout, span;                                                // Je declare les variable
window.onload = () => {                                                           // attender que le dom soit charger
  collection = document.querySelector('#structuresDroits');               // Je vais charger la collection du formulaire(la div complete).
  span = collection.querySelector("span");                                // Je vais chercher le span dans la collection

  boutonAjout = document.createElement("button");                         //cree le button Ajout
  boutonAjout.className = "ajout-droit btn btn-success my-2";                     // class du button
  boutonAjout.innerText = "Ajouter une permission";                               // Je declare le texte

let nouveauBouton = span.append(boutonAjout);                                     // Je l'intègre dans le span

  collection.dataset.index = collection.querySelectorAll("input").length; // il va nous dire combien de formulaire il y à l'intérieur

  boutonAjout.addEventListener("click", function(){                     // j'attends le click, et je fais une function
    addButton(collection, nouveauBouton);                                           // Je lui passe le button
  });
}

function addButton(collection, nouveauBouton){                                      // la function declarer declarer
  let prototype = collection.dataset.prototype;                                     // je récupère le prototype, il va dans collection et il récupère prototype
                                                                                    // dans la variable prototype je vais avoir la collection complete qu'il contient l'ensemble de tous les formulaires
  let index = collection.dataset.index;                                             // je récupère l'index

  prototype = prototype.replace(/__name__/g, index);                                // dans les __name__ de prototype, je le remplace par l'index

  let content = document.createElement("html");                             // je déclare un element html
  content.innerHTML = prototype;                                                    // objet du dom pour pouvoir faire un query selector
  let newForm = content.querySelector("div");                               // je fais un nouveau formulaire qu'il sera une div
                                                                                    // la difference entre prototype et newForm c'est que prototype est une chaine de character, et newForm va être le nouvel objet du dom
  let boutonSuppr = document.createElement("button");                       // on créer le button supprimer
  boutonSuppr.type = "button";
  boutonSuppr.className = "btn btn-danger my-2";
  boutonSuppr.id = "delete-droit-" + index;
  boutonSuppr.innerText = "Supprimer cette permission"

  newForm.append(boutonSuppr);                                                      // Je l'ajoute a mon form

  collection.dataset.index++;                                                       // comme je vais avoir plusieurs formulaires il faut augmenter l'index

  let boutonAjout = collection.querySelector(".ajout-droit");                       // Je récupère le bouton ajout pour pouvoir de placer le button en dessous du button supprimer

  span.insertBefore(newForm, boutonAjout);                                          // j'ajoute mon formulaire avant le button ajout

  boutonSuppr.addEventListener("click", function (){                    // et on donne l'action de supprimer le formulaire parent
    this.previousElementSibling.parentElement.remove();
  })
}