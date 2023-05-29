<?php

include_once 'utilitaire.php';
include_once 'commfonctions.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
    $res = supprimerLigne($id, 'comptes.csv');
    if ($res === -1){
        echo "Erreur dans la mise à jour de la note.";
    }
    else if ($res === 1){
        echo "Votre compte a été supprimé avec succès.";
    }
    else if ($res === true){
        echo "Votre compte a été supprimé avec succès.";
    }
    else if ($res === false){
        echo "Erreur à l'écriture du fichier.";
    }
    else {
        echo "Erreur inconnue : $res";
    }
    exit;
  } else {
    echo "Erreur : ID utilisateur manquant.";
  }
} else {
  echo "Erreur : Méthode de requête invalide.";
} 
?>