<!DOCTYPE html>
<?php include 'head.php'; ?> <!-- inclure le header : un div qui bouge si on fait défiler la page -->

<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="home.css">
  <title>BeautyMix • Page d'accueil</title>
</head>

<body>
  <section>
    <center>
      <br><br>
      <div class="form-box2">
        <center>
          <br>
          <h2 class="fifi">La meilleure recette de la semaine</h2><br>
        </center>
        <div id="Recette" class="form-box25">
          <?php
          $csvFile = file('stock.csv');
          $recipes = [];
          foreach ($csvFile as $line) {
            $recipes[] = str_getcsv($line, ';');
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
        
        

          function getBestRecipesByCategory($recipes, $category, $limit)
          {
            $filteredRecipes = array_filter($recipes, function ($recipe) use ($category) {
              return strtolower($recipe[3]) === strtolower($category);
            });

            usort($filteredRecipes, 'sortRecipesByRating');

            return array_slice($filteredRecipes, 0, $limit);
          }

          $bestRecipes = getBestRecipesByCategory($recipes, 'visage', 1); // Modifier la catégorie et le nombre de recettes affichées

          foreach ($bestRecipes as $recipe) {
            echo '<div class="form-box0">';
            echo '<div class="image-container">'; // Ajout de cette classe
            echo '<img src="' . $recipe[9] . '" class="image" alt="photorecette">';
            echo '</div>';
            echo '<div class="darari">';
            echo '<div>';
            echo '<center>';
            echo '<br>';
            echo '<h4 class="nomderecette">' . $recipe[1] . '</h4> <br>';
            echo '<p class="description">' . $recipe[2] . '</p><br>';
            echo '</center>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
          }
          
          
          
          ?>
        </div>
        <br><br>
      </div>
      <br><br><br><br>

      <div class="form-box2">
        <center>
          <br>
          <h2 class="fifi">Recettes pour le corps</h2><br>
        </center>

        
     
          <?php
          $bestRecipesCorps = getBestRecipesByCategory($recipes, 'corps', 4); // Modifier la catégorie et le nombre de recettes affichées
          
          foreach ($bestRecipesCorps as $recipe) {
            
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
          
        
        <br>
      </div>
      </div>
      </div>
              
      <br><br><br><br>

      <div class="form-box2">
        <center>
          <br>
          <h2 class="fifi">Recettes pour le visage</h2><br>
        </center>
        <center>
          <?php
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
        <br>
      </div>

      <br><br><br><br>

      <div class="form-box2">
        <center>
          <br>
          <h2 class="fifi">Recettes pour les cheveux</h2><br>
        </center>
        <center>
          <?php
          $bestRecipesCheveux = getBestRecipesByCategory($recipes, 'cheveux', 4); // Modifier la catégorie et le nombre de recettes affichées

          foreach ($bestRecipesCheveux as $recipe) {
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
        <br>
      </div>

  </section>

  </center>
  <script src="classement.js"></script>
</body>

<?php 
  include 'footer.html'; 
?>

</html>
