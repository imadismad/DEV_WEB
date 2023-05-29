<?php

include_once 'utilitaire.php';
include_once 'comptesfonctions.php';

if (!empty($_POST)){
    // Récupération des données du formulaire
    $nom = $_POST['surname'];
    $prenom = $_POST['name'];
    $email = $_POST['email'];
    $mdp = $_POST['password'];
    echo modifierCompte($nom, $prenom, $mail, $mdp);
}

?>