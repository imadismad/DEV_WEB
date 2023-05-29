<?php
include "head.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter une recette de cosmétique</title>
    <!-- Intégration des fichiers CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">
    <style>
        body {
            background-image: url("background.jpg");
            background-size: cover;
            color: white;
        }
        
        .container {
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.5);
            border-radius: 20px;
            backdrop-filter: blur(15px);
        }

        .list-group-item{
            background-color: transparent;
            color: white;
        }
        

        .form-control{
            background-color: transparent;
            color: white;
        }
        
        input[type="text"],
        input[type="number"],
        textarea,
        select {
            background-color: transparent;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-5">Ajouter une recette de cosmétique</h1>
        <?php
        // Afficher les messages d'erreur ou de succès
        if (isset($_GET['erreur']) && $_GET['erreur'] == 1) {
            echo '<div class="alert alert-danger" role="alert">Veuillez remplir tous les champs du formulaire.</div>';
        } elseif (isset($_GET['erreur']) && $_GET['erreur'] == 2) {
            echo '<div class="alert alert-danger" role="alert">Erreur lors du téléchargement de l\'image.</div>';
        } elseif (isset($_GET['success']) && $_GET['success'] == 1) {
            echo '<div class="alert alert-success" role="alert">La recette a été ajoutée avec succès.</div>';
        }
        ?>

        <form method="POST" action="ajout_recette.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="titre">Titre :</label>
                <input type="text" class="form-control" name="titre" required>
            </div>

            <div class="form-group">
                <label for="categorie">Catégorie :</label>
                <select class="form-control" name="categorie" required>
                    <option value="">--Choisir--</option>
                    <option value="cheveux">Cheveux</option>
                    <option value="visage">Visage</option>
                    <option value="corps">Corps</option>
                    <option value="autre">Autre</option>
                </select>
            </div>

            <div class="form-group">
                <label for="difficulte">Difficulté :</label>
                <select class="form-control" name="difficulte" required>
                    <option value="">--Choisir--</option>
                    <option value="facile">Facile</option>
                    <option value="intermediaire">Intermédiaire</option>
                    <option value="difficile">Difficile</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description :</label>
                <textarea class="form-control" name="description" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="mots-cles">Mots-clés :</label>
                <input type="text" class="form-control" name="mots-cles" required>
            </div>

            <div class="form-group">
                <label for="image">Image :</label>
                <input type="file" class="form-control-file" name="image" id="image" required>
            </div>

            <div class="form-group">
                <label for="ingredients">Ingrédients :</label>
                <div class="input-group">
                    <select class="form-control" name="ingredients" id="ingredients">
                        <option value="">--Choisir--</option>
                        <?php
                        // Lire les ingrédients à partir du fichier CSV
                        $ingredients = array_map('str_getcsv', file('ingredients_valides.csv'));
                        // Parcourir les ingrédients et les afficher comme options dans la liste déroulante
                        foreach ($ingredients as $ingredient) {
                            echo '<option value="' . $ingredient[0] . '">' . $ingredient[0] . '</option>';
                        }
                        ?>
                    </select>
                    <input type="text" class="form-control" name="ingredient-personnalise" id="ingredient-personnalise" placeholder="Ingrédient personnalisé">
                    <input type="number" class="form-control" name="prix-personnalise" id="prix-personnalise" placeholder="Prix au kilo (€)" step="0.01" min="0">

                    <div class="input-group-append">
                        <label for="quantite" class="input-group-text">Quantité :</label>
                    </div>
                    <input type="number" class="form-control" name="quantite" id="quantite" step="1">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-primary" onclick="ajouterIngredient()">Ajouter</button>
                    </div>
                </div>
            </div>

            <input type="submit" class="btn btn-success mb-4" value="Ajouter la recette">
        </form>

        <h2>Ingrédients ajoutés :</h2>
        <ul class="list-group mb-4" id="liste-ingredients">
            <!-- Liste des ingrédients ajoutés via JavaScript -->
        </ul>

        <div id="estimation-prix" class="mb-5">
            <h2>Estimation du prix :</h2>
            <p id="prix-total" class="lead">0.00€</p>
            <input type="hidden" id="prix-total-input" name="prix-total-input">
        </div>
    </div>

    <!-- Intégration des fichiers JavaScript de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <!-- Intégration du fichier JavaScript personnalisé -->
    <script src="ajout_recette.js"></script>
</body>
</html>
