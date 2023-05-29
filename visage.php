<?php
include 'head.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="home.css">
  <title>Visage</title>
</head>
<body>
<div class="main-container">
<center>
          <br>
          <h2 class="fifi">Recettes pour le visage</h2><br>
        </center>
        <center>
          <?php
            function getBestRecipesByCategory($recipes, $category, $limit)
            {
                $filteredRecipes = array_filter($recipes, function ($recipe) use ($category) {
                    return strtolower($recipe[3]) === strtolower($category);
                });

                usort($filteredRecipes, 'sortRecipesByRating');

                return array_slice($filteredRecipes, 0, $limit);
            }

            function sortRecipesByRating($a, $b) {
                if ($a[4] == $b[4]) {
                    return 0;
                } elseif ($a[4] < $b[4]) {
                    return 1;
                } else {
                    return -1;
                }
            }

          $csvFile = file('stock.csv');
          $recipes = [];
          foreach ($csvFile as $line) {
            $recipes[] = str_getcsv($line, ';');
          }

          $bestRecipesVisage = getBestRecipesByCategory($recipes, 'visage', 4); // Modifier la catégorie et le nombre de recettes affichées

          foreach ($bestRecipesVisage as $recipe) {
            echo '<div class="form-box0 reverse">';
            echo '<div class="image-container">';
            echo '<img src="' . $recipe[9] . '" class="image" alt="photorecette">';
            echo '</div>';
            echo '<div class="darari">';
            echo '<div>';
            echo '<center>';
            echo '<h4 class="nomderecette">' . $recipe[1] . '</h4>';
            echo '</center>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
          ?>
        </center>
</div>
</body>
</html>
