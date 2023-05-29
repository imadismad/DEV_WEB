<?php
include 'head.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="recherche.css">
  <title>Résultats de recherche</title>
</head>
<body>
<div class="main-container">
  <?php
  // Vérifier si le terme de recherche est fourni dans la requête GET
  if (isset($_GET['searchInput'])) {
    $searchTerm = $_GET['searchInput'];

    // Lire le fichier stock.csv
    $stockFile = fopen('stock.csv', 'r');

    if ($stockFile) {
      // Afficher les résultats de recherche correspondant au terme recherché
      while (($line = fgetcsv($stockFile, 0, ';')) !== false) {
        $title = $line[1]; // Le titre est situé au deuxième champ (indice 1)
        $image = $line[8]; // Le chemin de l'image est situé au neuvième champ (indice 8)
        $ingredients = array_slice($line, 9); // Les ingrédients commencent à partir du dixième champ (indice 9)

        // Vérifier si le titre de la recette contient le terme de recherche
        if (stripos($title, $searchTerm) !== false) {
          // Afficher l'image et le titre de la recette
          echo '<div class="recipe">';
          echo '<img src="' . $image . '">';
          echo '<h2>' . $title . '</h2>';

          // Afficher les ingrédients de la recette
          echo '<ul>';

          echo '</ul>';

          echo '</div>';
        }
      }

      // Fermer le fichier stock.csv
      fclose($stockFile);
    } else {
      echo 'Erreur lors de l\'ouverture du fichier stock.csv.';
    }
  }
  ?>
</div>
</body>
</html>
