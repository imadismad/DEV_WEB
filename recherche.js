// Récupération du formulaire et des champs
const formulaire = document.getElementById('recherche');
const motsInput = document.getElementById('motsclefs');

// Écoute de l'événement "submit" du formulaire
formulaire.addEventListener('submit', function(event) {
  event.preventDefault(); // Empêche l'envoi du formulaire

  // Validation des champs du formulaire
  let isValid = true;
  if (motsInput.value.trim() === '') {
    isValid = false;
  }

  if (isValid) {
    // Création de l'objet XMLHttpRequest
    const xhr = new XMLHttpRequest();

    // Configuration de la requête AJAX
    xhr.open('POST', 'recherche.php', true);

    // Événement de réponse de la requête
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {

          //On récupère la réponse du php, et on le sépare dans un tableau
          const response = xhr.responseText;
          var tabid= response.split("/").filter(function(word) {
            //On exclut quand c'est vide
            return word !== "";
          });

          //Si le tableau n'est pas vide, alors on poursuit
          if (tabid.length !== 0){

            //On renvoie l'utilisateur sur la page de recherche dédiée et on récupère le div affichage où seront affichés les recettes
            window.location.href = 'recherchehtml.php';
            const aff = document.getElementById('affichage');

            //On parcourt le tableau
            for(var ligne of tabid){

              //On récupère les champs de chaque recette pour les intégrer au html qu'on va rajouter dans le div
              var champs=ligne.split(";").filter(function(word) {
                return word !== "";
              });

              //Affichage
            }
          }

        } else {
          // Gestion des erreurs
          console.error('Erreur lors de la requête AJAX');
        }
      }
    };

    // Définition de l'en-tête de la requête
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Envoi de la requête avec les données du formulaire
    const data = `motsclefs=${encodeURIComponent(motsInput.value)}`;
    xhr.send(data);
    }
  }
);

// Fonction de validation de l'email
function validateEmail(email) {
  const re = /\S+@\S+\.\S+/;
  return re.test(email);
}
