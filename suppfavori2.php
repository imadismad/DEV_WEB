<?php

include_once 'utilitaire.php';
include_once 'favorisfonctions.php';

$_SESSION['iduser']='647322c60fe4e';
$id=$_SESSION['iduser'];
$idp=$_POST['idrecette'];

echo supprimerFavori($id, $idp);

?>