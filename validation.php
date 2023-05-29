<?php
$userId = ""; // Initialize the userId variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Valider l'ingrédient et le déplacer vers ingredients_valides.csv
  if (isset($_POST['validatedIngredient'])) {
    $validatedIngredient = $_POST['validatedIngredient'];
    $ingredientsNonValides = file('ingredients_non_valides.csv');
    $updatedIngredientsNonValides = [];
    $validatedIngredientLine = "";
    foreach ($ingredientsNonValides as $line) {
      $parts = explode(';', $line);
      $ingredientId = $parts[0];
      if ($ingredientId !== $validatedIngredient) {
        $updatedIngredientsNonValides[] = $line;
      } else {
        $validatedIngredientLine = $line;
      }
    }
    file_put_contents('ingredients_non_valides.csv', implode('', $updatedIngredientsNonValides), LOCK_EX);
    file_put_contents('ingredients_valides.csv', $validatedIngredientLine, FILE_APPEND | LOCK_EX);
    exit;
  }

  // Rejeter l'ingrédient et le supprimer de ingredients_non_valides.csv
  if (isset($_POST['rejectedIngredient'])) {
    $rejectedIngredient = $_POST['rejectedIngredient'];

    // Supprimer l'ingrédient rejeté de ingredients_non_valides.csv
    $ingredientsNonValides = file('ingredients_non_valides.csv');
    $updatedIngredientsNonValides = [];
    foreach ($ingredientsNonValides as $line) {
      $parts = explode(';', $line);
      $ingredientId = $parts[0];
      if ($ingredientId !== $rejectedIngredient) {
        $updatedIngredientsNonValides[] = $line;
      }
    }
    file_put_contents('ingredients_non_valides.csv', implode('', $updatedIngredientsNonValides), LOCK_EX);

    exit;
  }
}

// Charger les ingrédients depuis le fichier ingredients_non_valides.csv
$ingredients = [];
if (($handle = fopen('ingredients_non_valides.csv', 'r')) !== false) {
  $headers = fgetcsv($handle, 0, ';');
  while (($data = fgetcsv($handle, 0, ';')) !== false) {
    $ingredient = array_combine($headers, $data);
    $ingredients[] = $ingredient;
  }
  fclose($handle);
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Validation des ingrédients</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .ingredient-block {
      border: 1px solid #ddd;
      padding: 20px;
      margin-bottom: 20px;
    }
    .ingredient-block h3 {
      margin-top: 0;
    }
    .ingredient-block p {
      margin-bottom: 5px;
    }
    .ingredient-block button {
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Validation des ingrédients</h1>

    <div id="ingredientsContainer">
      <?php foreach ($ingredients as $ingredient): ?>
        <div class="ingredient-block" data-ingredient-id="<?= $ingredient['ID'] ?>">
          <h3><?= $ingredient['Ingrédient'] ?></h3>
          <p>Prix (€/kg): <?= $ingredient['Prix (€/kg)'] ?></p>
          <button class="btn btn-success" onclick="validateIngredient(<?= $ingredient['ID'] ?>)">Valider</button>
          <button class="btn btn-danger" onclick="rejectIngredient(<?= $ingredient['ID'] ?>)">Rejeter</button>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <script>
    function validateIngredient(ingredientId) {
      var validatedIngredient = ingredientId;

      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          location.reload();
        }
      };
      xhr.open('POST', 'validation.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.send('validatedIngredient=' + encodeURIComponent(validatedIngredient));
    }

    function rejectIngredient(ingredientId) {
      var rejectedIngredient = ingredientId;

      var xhr = new XMLHttpRequest();
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          location.reload();
        }
      };
      xhr.open('POST', 'validation.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.send('rejectedIngredient=' + encodeURIComponent(rejectedIngredient));
    }
  </script>
</body>
</html>
