<?php
require_once 'utilitaire.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Récupérer les nouvelles coordonnées depuis le formulaire
  $nouveauNom = $_POST['surname'];
  $nouveauPrenom = $_POST['name'];
  $nouvelEmail = $_POST['email'];
  $nouveauMotDePasse = $_POST['password'];

  if (strpos($nouveauNom, ';') !== false || strpos($nouveauPrenom, ';') !== false || strpos($nouvelEmail, ';') !== false || strpos($nouveauMotDePasse, ';') !== false) {
    return "Les champs ne peuvent pas contenir le caractère (;).";
  }

  if (!strpos($nouvelEmail, '@') && !empty($nouvelEmail)) {
    return "Le format du mail est invalide.";
  }

  // Si le mail existe déjà dans le CSV, l'opération est impossible
  if (existenceMail($nouvelEmail) && $nouvelEmail !== $_SESSION['email']) {
    return "Mail déjà existant.";
  }

  // Vérifier si le fichier CSV existe
  if (file_exists('comptes.csv')) {
    // Lire le contenu du fichier CSV
    $donnees = file('comptes.csv');

    // Parcourir les lignes du fichier CSV
    foreach ($donnees as $index => $ligne) {
      // Diviser la ligne en colonnes
      $colonne = explode(';', $ligne);

      // Récupérer l'ID de l'utilisateur
      $idUtilisateur = $colonne[0];

      // Vérifier si l'ID correspond à l'ID de l'utilisateur en cours de session
      if ($idUtilisateur === $_SESSION['id']) {
        // Mettre à jour les coordonnées si les champs ont été modifiés
        if (!empty($nouveauNom)) {
          $colonne[1] = $nouveauNom;
        }
        if (!empty($nouveauPrenom)) {
          $colonne[2] = $nouveauPrenom;
        }
        if (!empty($nouvelEmail)) {
          $colonne[3] = $nouvelEmail;
        }
        if (!empty($nouveauMotDePasse)) {
          $colonne[4] = $nouveauMotDePasse;
        }

        // Reconstruire la ligne avec les nouvelles valeurs
        $nouvelleLigne = implode(';', $colonne);

        // Mettre à jour la ligne dans le tableau des données
        $donnees[$index] = $nouvelleLigne;

        // Sortir de la boucle, car nous avons trouvé l'utilisateur
        break;
      }
    }

    // Réécrire le contenu du fichier CSV avec les modifications
    file_put_contents('comptes.csv', implode('', $donnees));

    // Mettre à jour les variables de session avec les nouvelles coordonnées
    $_SESSION['nom'] = $nouveauNom;
    $_SESSION['prenom'] = $nouveauPrenom;
    $_SESSION['email'] = $nouvelEmail;

    // Rediriger vers la page actuelle pour l'actualiser
    header('Location: ' . "moncompte.php");
    exit;
  } else {
    echo "Le fichier CSV des comptes n'existe pas.";
  }
}
?>
