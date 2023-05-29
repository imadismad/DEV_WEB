<?php
include 'head.php';

  // Identifiant du compte
  $id = $_SESSION['id'];
  // Informations du compte
  $nom = $_SESSION['nom'];
  $prenom = $_SESSION['prenom'];
  $email = $_SESSION['email'];


  // Initialisation des variables de session
  $_SESSION['id'] = $id;
  $_SESSION['nom'] = $nom;
  $_SESSION['prenom'] = $prenom;
  $_SESSION['email'] = $email;


// Récupération des coordonnées actuelles
$nomActuel = isset($_SESSION['nom']) ? $_SESSION['nom'] : '';
$prenomActuel = isset($_SESSION['prenom']) ? $_SESSION['prenom'] : '';
$emailActuel = isset($_SESSION['email']) ? $_SESSION['email'] : '';
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeautyMix • Mon compte</title>
    
      <link rel="stylesheet" href="moncompte.css">
  

    
</head>
<body>
  <section>
      <br><br>
      <br>
      <center>
        <div class="form-box" id="coordonnees"><!--cadre pour les coordonnées, changeables et actualisables-->
        <form action="miseajourcoordonnees.php" method="post" id="changement">
          <center><h2>Coordonnées</h2></center>
          <div id="erreur"></div>
          <br>
          <div class="inputbox"><!--div pour les inputs-->
            <input type="text" id="surname" name="surname" value="<?php echo $nomActuel; ?>">
            <label for="">Nom</label>
          </div>
          <div class="inputbox">
            <input type="text" id="name" name="name" value="<?php echo $prenomActuel; ?>">
            <label for="">Prénom</label>
          </div>
          <div class="inputbox">
            <input type="email" id="email" name="email" value="<?php echo $emailActuel; ?>">
            <label for="">Adresse mail</label>
          </div>
          <div class="inputbox">
            <input type="password" id="password" name="password" placeholder="Mot de passe">
            <label for="">Mot de passe</label>
          </div>
          <button type="submit">Changer mes informations</button>
        </form>
        </div>
        <br><br>
        <center>
        <button id="logoutButton">Déconnexion</button>
        </center>
        <br><br><br><br>
        <div class="form-box2"><!--div pour les recettes créées par l'utilisateur-->
          <h2>Mes recettes</h2>
          <br>
          <!--case d'une recettes-->
          <div class="form-box25">
            <a href="">
              <img class="imagerecette" src="chat.jpeg" alt="photorecette"><br>
              <center><label class="nomrecette">Pastis</label></center><br>
              <p class="descriptionrecette">Je mange le pastis et je bois du cochonou</p><br>
            </a>
            <button class="choice">Supprimer</button>
          </div>
          <br><br>
          <!--case d'une recettes-->
          <div class="form-box25">
            <a href="">
              <img class="imagerecette" src="chat.jpeg" alt="photorecette"><br>
              <center><label class="nomrecette">Pastis</label></center><br>
              <p class="descriptionrecette">Je mange le pastis et je bois du cochonou</p><br>
            </a>
            <button class="choice">Supprimer</button>
          </div>
          <br><br>
          <button id="ajout" class="choice">Ajouter</button><!--bouton pour ajouter une nouvelle recette-->
        </div>
        <script>document.getElementById('ajout').addEventListener('click', function() {
          // Rediriger vers une autre page après la déconnexion
          window.location.href = 'ajout_recette.php';
      });
        </script>
        <br><br><br><br>
        <div class="form-box2"><!--div pour les recettes favorites de l'utilisateur-->
          <h2>Mes recettes favorites</h2>
          <br>
          <!--case d'une recettes-->
          <div class="form-box25">
            <a href="">
              <img class="imagerecette" src="chat.jpeg" alt="photorecette"><br>
              <center><label class="nomrecette">Pastis</label></center><br>
              <p class="descriptionrecette">Je mange le pastis et je bois du cochonou</p><br>
            </a>
          </div>
          <br><br>
          <!--case d'une recettes-->
          <div class="form-box25">
            <a href="">
              <img class="imagerecette" src="chat.jpeg" alt="photorecette"><br>
              <center><label class="nomrecette">Pastis</label></center><br>
              <p class="descriptionrecette">Je mange le pastis et je bois du cochonou</p><br>
            </a>
          </div>
        </div>
      </center>
      <br><br><br>
      <button id="suppressioncompte" onclick="confirmation()">Supprimer mon compte</button><!--bouton pour supprimer le compte-->
      <br><br><br>
      <script>
      document.getElementById('logoutButton').addEventListener('click', function() {
      // Appeler le script PHP pour détruire les cookies
      fetch('deconnexion.php')
        .then(function(response) {
          // Rediriger vers une autre page après la déconnexion
          window.location.href = 'pageAccueil.php';
        })
      .catch(function(error) {
      console.log('Une erreur s\'est produite :', error);
      });
      });
      </script>
  </section>
  <!-- <script src="suppressioncompte.js"></script> -->
</body>
</html>