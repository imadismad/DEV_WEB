<?php

include_once 'utilitaire.php';
include_once 'comptesfonctions.php';


if(isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $res=login($email, $password);
    if($res===1) {
        echo "success";
    }
    else if ($res === 2){
        echo "Adresse mail ou mot de passe invalide.";
    }
    else if ($res===3){
        echo "Erreur à l'ouverture du fichier.";
    }
    else{
        echo "Erreur inconnue.";
    }
    
}

?>