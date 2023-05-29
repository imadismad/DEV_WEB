<?php
session_start();
?>


<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="head.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
  </head>
  <body>
    <header>
      <a href="pageAccueil.php" class="logo">
        <img src="./leaf1.png" alt="logo">
        <span>Beautymix</span>
      </a>
      <div class="group">
        <ul class="navigation">
          <li>
            <a href="#">Recettes</a>
            <div class="option">
              <ul>
                <li>
                  <span>Par catégorie</span>
                  <ul>
                    <li><a href="visage.php"><span>Visage</span></a></li>
                    <li><a href="cheveux.php"><span>Cheveux</span></a></li>
                    <li><a href="corps.php"><span>Corps</span></a></li>
                  </ul>
                </li>
              </ul>
            </div>
          </li>
          <li><a href="https://dermoplant.com/fr/questionnaire-quel-est-votre-type-de-peau/">Quiz</a></li>
          <li><a href="aboutus.php">Sur nous</a></li>
          <li><a href="contact.php">Contact</a></li>
          <li><a href="connexion.php">Compte</a></li>
        </ul>
        <div class="search">
          <span class="icon">
            <ion-icon name="search" class="searchBtn"></ion-icon>
            <ion-icon name="close" class="closeBtn"></ion-icon>
          </span>
        </div>
        <ion-icon name="menu-outline" class="menu"></ion-icon>
      </div>
      
      <div class="searchBox">
        <form action="recherche.php" method="GET">
          <div class="searchInput">
            <input type="text" placeholder="Recherche . . ." name="searchInput" autocomplete="off">
            <datalist id="suggestionsList"></datalist>
          </div>
          <input type="submit" value="Chercher" class="submitBtn">
        </form>
      </div>
    </header>
 
    <!-- Script pour pouvoir utiliser les icones rechercher et fermer -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- Script pour les boutons search et close -->
    <script>
    let searchBtn = document.querySelector('.searchBtn');
    let closeBtn = document.querySelector('.closeBtn');
    let searchBox = document.querySelector('.searchBox');
    let navigation = document.querySelector('.navigation');
    let menu = document.querySelector('.menu');
    let header = document.querySelector('header');
    let searchForm = document.querySelector('.searchBox form');
    
    searchBtn.onclick = function () {
      searchBox.classList.add('active');
      closeBtn.classList.add('active');
      searchBtn.classList.add('active');
      menu.classList.add('hide');
      header.classList.remove('open');
      searchForm.innerHTML = '<input type="text" placeholder="Recherche . . ." name="searchInput"><input type="submit" value="Chercher" class="submitBtn">';
    }
    
    closeBtn.onclick = function () {
      searchBox.classList.remove('active');
      closeBtn.classList.remove('active');
      searchBtn.classList.remove('active');
      menu.classList.remove('hide');
      searchForm.innerHTML = '<input type="text" placeholder="Recherche . . .">';
    }
    
    menu.onclick = function () {
      header.classList.toggle('open');
      searchBox.classList.remove('active');
      closeBtn.classList.remove('active');
      searchBtn.classList.remove('active');
    }
    
    // Fonction pour récupérer les suggestions de recherche
    function fetchSuggestions() {
      var searchTerm = document.getElementById('searchinfo').value;
      suggestionsList.innerHTML = ''; // Réinitialiser la liste des suggestions
    
      // Effectuer une requête AJAX ou utiliser votre propre logique pour obtenir les suggestions
      // Ici, nous ajoutons des suggestions statiques à titre d'exemple
      var suggestions = ['Visage', 'Cheveux', 'Corps', 'Citron', 'Miel', 'Rass l7anout'];
      suggestions.forEach(function (suggestion) {
        var option = document.createElement('option');
        option.value = suggestion;
        suggestionsList.appendChild(option);
      });
    }
    
    // Écouter l'événement d'entrée dans le champ de recherche pour récupérer les suggestions
    document.getElementById('searchinfo').addEventListener('input', fetchSuggestions);
  </script> 
  </body>
</html>
