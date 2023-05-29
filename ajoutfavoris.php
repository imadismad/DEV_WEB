<?php

include_once 'utilitaire.php';
include_once 'favorisfonctions.php';

$_SESSION['id']='647322c60fe4e';
$id=$_SESSION['id'];
$produit_id=$_POST['idrecette'];


echo ajouterFavori($id, $produit_id);

?>