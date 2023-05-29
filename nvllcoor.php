<?php

include_once 'utilitaire.php';
include_once 'comptesfonctions.php';


$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$mail = $_POST['mail'];
$mdp = $_POST['mdp'];

$res=modifierCompte($nom,$prenom,$mail,$mdp);
echo "$res";

?>