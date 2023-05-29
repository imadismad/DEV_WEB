const id = document.getElementById('idrecette');

function likeAction(){

    const xhr = new XMLHttpRequest();

    // Configuration de la requête AJAX
    xhr.open('POST', 'ajoutfavoris.php', true);

    // Événement de réponse de la requête
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          const response = xhr.responseText;
          if (response !== 'success') {
            // Affichage du message d'erreur
            alert(response);
          }
        } else {
          // Gestion de l'erreur de la requête
          alert('Une erreur est survenue lors de la requête.');
        }
      }
    };

    // Définition de l'en-tête de la requête
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Envoi de la requête avec les données du formulaire
    const data = `idrecette=${encodeURIComponent(id.value)}`;
    xhr.send(data);
}

function unlikeAction(){
  const xhr = new XMLHttpRequest();

  // Configuration de la requête AJAX
  xhr.open('POST', 'suppfavori2.php', true);

  // Événement de réponse de la requête
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const response = xhr.responseText;
        if (response !== 'success') {
          // Affichage du message d'erreur
          alert(response);
        }
      } else {
        // Gestion de l'erreur de la requête
        alert('Une erreur est survenue lors de la requête.');
      }
    }
  };

  // Définition de l'en-tête de la requête
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  // Envoi de la requête avec les données du formulaire
  const data = `idrecette=${encodeURIComponent(id.value)}`;
  xhr.send(data);
}