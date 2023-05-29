<?php

require_once 'utilitaire.php';

function login($email, $password) {
    // Vérification des informations de connexion
    $user_found = false;
    $handle = fopen('comptes.csv', 'r');

    //On vérifie que le fichier s'est ouvert correctement
    if ($handle==false){
        echo 'Erreur à l\'ouverure du fichier.';
        return 3;
    }

    while(($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
        if($data[3] == $email && $data[4] == $password) {
            $user_found = true;
            // Démarrage de la session
            session_start();
            // Stockage des informations de l'utilisateur dans la session
            $_SESSION['id'] = $data[0];
            $_SESSION['nom'] = $data[1];
            $_SESSION['prenom'] = $data[2];
            $_SESSION['email'] = $data[3];
            $_SESSION['admin'] = $data[5];
            $_SESSION['favoris'] = array(); // initialisation du tableau des favoris
            if(!empty($data[6])) {
                // Récupération des favoris de l'utilisateur à partir du fichier CSV
                $favoris = explode(',', $data[6]);
                $_SESSION['favoris'] = array_map('intval', $favoris);
            }
            // On stocke un cookie pour vérifier que l'utilisateur est bien connecté
            setcookie('user_logged_in', 'true', time() + 3600, '/');
            if ($_SESSION['admin']==1){
                setcookie('admin', 'true', time() + 3600, '/');
            }
            break;
        }
    }
    fclose($handle);

    if($user_found == false){
        return 2;
    }

    return 1;
}

function creation_compte(){
    // Vérification que le formulaire a été soumis
    if(!empty($_POST)) {

        // Récupération des données du formulaire
        $nom = $_POST['surname'];
        $prenom = $_POST['name'];
        $email = $_POST['email'];
        $mdp = $_POST['password'];
        $admin = 0;
        $fav = '';

        // Vérification que toutes les données ont été fournies
        if(empty($nom) || empty($prenom) || empty($email) || empty($mdp)) {
            echo 'Un ou plusieurs champs sont vides.';
            return false;
        }

        if(strpos($nom, ';') || strpos($prenom, ';') || strpos($email, ';') || strpos($mdp, ';')) {
            echo 'Le caractère \';\' est interdit.';
            return false;
        }

        if(!strpos($email, '@')){
            echo 'Le mail doit contenir un @.';
            return false;
        }

        if (existenceMail($email)==false){

            // Ouverture du fichier en mode écriture
            $file = fopen('comptes.csv', 'a');

            //On vérifie que le fichier s'est ouvert correctement
            if ($file==false){
                echo "Fichier impossible à ouvrir";
                return false;
            }
        
            // Génération d'un ID unique
            $id = uniqid();

            // Création d'une ligne au format CSV
            $line = "$id;$nom;$prenom;$email;$mdp;$admin;$fav\n";


            // Écriture de la ligne dans le fichier
            fwrite($file, $line);

            // Fermeture du fichier
            fclose($file);

            echo "success";
            return true;
        }
        else{
            echo "Ce mail est déjà utilisé.";
            return false;
        }
    }
}

function modifierCompte($nom, $prenom, $mail, $mdp) {
    // Vérification de l'existence de la session et du champ 'id' de l'utilisateur
    if (isset($_SESSION['id'])) {
        // Récupération de l'identifiant de l'utilisateur
        $id = $_SESSION['id'];
    

        if(strpos($nom, ';') || strpos($prenom, ';') || strpos($mail, ';') || strpos($mdp, ';')) {
            return "Les champs ne peuvent pas contenir le caractère (;) .";
        }

        if(!strpos($mail, '@')&&!empty($mail)){
            return "Le format du mail est invalide.";
        }

        //Si le mail existe déjà dans le csv, l'opération est impossible
        if (existenceMail($mail)&&$mail!==$_SESSION['mail']){
            return "Mail déjà existant.";
        }

        //On crée un tampon qui nous permettra de réécrire le fichier en modifiant la ligne qui nous intéresse
        $tmp='';

        // Ouverture du fichier comptes.csv en lecture et écriture
        $fichier = fopen("comptes.csv", 'r+');

        //On vérifie que le fichier s'est ouvert correctement
        if ($fichier==false){
            return "Fichier impossible à ouvrir";
        }
        
        // Parcours du fichier ligne par ligne
        while (($ligne = fgetcsv($fichier, 10000, ';')) !== FALSE) {
            //Dans l'objectif d'éviter les erreurs, on saute les lignes vides
            if(empty($ligne)){
                continue;
            }

            // Recherche de l'utilisateur correspondant à l'identifiant
            if ($ligne[0] == $id) {
                //On vérifie quels champs sont vides et donc ne doivent pas être modifiés
                if(empty($nom)){
                    $nom=$ligne[1];
                }  
                if(empty($prenom)){
                    $prenom=$ligne[2];
                }
                if(empty($mail)){
                    $mail=$ligne[3];
                }
                if(empty($mdp)){
                    $mdp=$ligne[4];
                }

                //On garde les champs admin et favoris
                $admin=$ligne[5];
                $fav=$ligne[6];

                //On écrit dans le tampon la ligne modifiée
                $tmp.="$id;$nom;$prenom;$mail;$mdp;$admin;$fav\n";
                 
            }
            else {
                $tmp.=implode(';',$ligne)."\n";
            }
        }
        
        //On efface le contenu du csv et on réécrit le tampon à la place, en vérifiant que l'écriture s'est effectuée avec succès
        ftruncate($fichier,0);
        if (file_put_contents('comptes.csv', $tmp) === false) {
            fclose($fichier);
            return "Erreur lors de l'écriture dans le fichier";
        }

        fclose($fichier);
        echo "success";
    } else {
        echo "Utilisateur non connecté.";
    }
}

?>