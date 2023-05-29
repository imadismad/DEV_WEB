// Récupération du formulaire et des champs
const formulaire = document.getElementById('form');
const emailInput = document.getElementById('email');
const mdpInput = document.getElementById('password');
const erreurDiv = document.getElementById('erreur');

// Écoute de l'événement "submit" du formulaire
formulaire.addEventListener('submit', function(event) {
  event.preventDefault(); // Empêche l'envoi du formulaire

  // Validation des champs du formulaire
  let isValid = true;
  if (emailInput.value.trim() === '') {
    isValid = false;
    erreurDiv.textContent = 'Veuillez saisir votre email';
  } else if (!validateEmail(emailInput.value.trim())) {
    isValid = false;
    erreurDiv.textContent = 'Le format de l\'email est invalide';
  }
  if (mdpInput.value.trim() === '') {
    isValid = false;
    erreurDiv.textContent = 'Veuillez saisir votre mot de passe';
  }

  if (isValid) {
    // Création de l'objet XMLHttpRequest
    const xhr = new XMLHttpRequest();

    // Configuration de la requête AJAX
    xhr.open('POST', 'connexionfct.php', true);

    // Événement de réponse de la requête
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          const response = xhr.responseText;
          if (response === 'success') {
            // Redirection vers la page de connexion
            window.location.href = 'pageaccueil.php';
          } else {
            // Affichage du message d'erreur
            erreurDiv.textContent = response;
          }
        } else {
          // Gestion de l'erreur de la requête
          erreurDiv.textContent = 'Une erreur est survenue lors de la requête.';
        }
      }
    };

    // Définition de l'en-tête de la requête
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Envoi de la requête avec les données du formulaire
    const data = `email=${encodeURIComponent(emailInput.value)}&password=${encodeURIComponent(mdpInput.value)}`;
    xhr.send(data);
  }
});

// Fonction de validation de l'email
function validateEmail(email) {
  const re = /\S+@\S+\.\S+/;
  return re.test(email);
}
