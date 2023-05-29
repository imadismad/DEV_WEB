<?php

function existeid($id,$csv){
    //On vérifie que le paramètre existe
    if (empty($id)){
        return false;
    }

    //On ouvre le fichier et on vérifie l'ouverture correcte 
    $file=file_get_contents($csv);
    if (empty($file)){
        echo"Erreur: Ouverture du fichier impossible.";
        exit;
    }

    //On sépare le fichiers en lignes et on parcours toutes ces lignes
    $lines=explode("\n",$file);
    foreach($lines as $line){
        //On exclue les lignes vides
        if (empty($line)){
            continue;
        }

        //Si on trouve l'id, alors il est bien dans le csv, donc on renvoie true
        if (strpos($id,$line)){
            return true;
        }
    }

    fclose($file);

    //Si on a parcouru tout le fichier sans rien trouver, on renvoie false car l'utiilisateur n'est pas dans le fichier
    return false;
}



function existeFavori($id, $produit_id){
    //On vérifie que les paramètres existent
    if (empty($id)||empty($produit_id)){
        return false;
    }

    // Récupération du contenu du fichier CSV
    $file=file_get_contents('comptes.csv');

    // Recherche de la ligne correspondant à l'ID utilisateur
    $lines=explode("\n",$file);
    foreach($lines as $line){

        //On passe les lignes vides
        if (empty($line)){
            continue;
        }

        //On vérifie si la ligne où l'on est correspond à celle de l'utilisateur que l'on cherche
        if (strpos($line,$id)!==false){

            //On place les favoris dans $favoris
            $fields = explode(";", $line);
            $favoris = $fields[6];

            //Si on trouve l'id du produit dans les favoris alors on renvoie true
            if (strpos($favoris,$produit_id)!==false){
                return true;
            }
            break;
        }
    }

    //Si on a parcouru toutes les lignes sans trouver l'utilisateur ou le favori en question à la ligne de l'utilisateur, on renvoie false 
    return false;
}


// Fonction pour ajouter un identifiant de produit au tableau de favoris
function ajouterFavori($id, $produit_id) {
    if(!existeFavori($id,$produit_id)&&existeid($id,'comptes.csv')&&existeid($produit_id,'stock.csv')){
        // Récupération du contenu du fichier CSV
        $file = file_get_contents('comptes.csv');

        //On vérifie que le fichier s'est ouvert correctement
        if (empty($file)){
            echo "Erreur: Ouverture du fichier impossible.";
            exit;
        }

        // Recherche de la ligne correspondant à l'ID utilisateur
        $lines = explode("\n", $file);
        foreach($lines as &$line) {
            if(strpos($line, $id) !== false) {
                // Ajout de l'identifiant de produit au tableau de favoris
                $fields = explode(";", $line);
                $favoris = $fields[6];
                if (!empty($favoris)){
                    $favoris_array = explode(",", $favoris);
                }
                $favoris_array[] = $produit_id;
                $favoris = implode(",", $favoris_array);
                $fields[6] = $favoris;
                $line = implode(";", $fields);
                break;
            }
        }

        // Écriture du contenu modifié dans le fichier CSV
        $file = implode("\n", $lines);
        file_put_contents('comptes.csv', $file);
    }
}

// Fonction pour supprimer un favori d'un utilisateur dans un fichier CSV
function supprimerFavori($iduser, $idproduit) {

    if (empty($iduser) || empty($idproduit)) {
        echo "Erreur: paramètres vides.";
        return false;
    }

    // Ouvre le fichier en mode lecture et écriture
    $fichier = fopen('comptes.csv', "r+");

    // On vérifie que le fichier s'est ouvert correctement
    if ($fichier == false) {
        echo "Fichier impossible à ouvrir";
        exit;
    }

    //On crée un tampon qui remplacera le contenu du fichier
    $tampon = ''; 

    // Parcours de chaque ligne du fichier
    while (($ligne = fgetcsv($fichier, 10000, ";")) !== FALSE) {

        // Si l'ID utilisateur correspond
        if ($ligne[0] == $iduser) {
            
            // Récupère les favoris actuels
            $favoris = explode(",", $ligne[6]);

            // Supprime le produit de la liste des favoris
            $index = array_search($idproduit, $favoris);
            if ($index !== false) {
                unset($favoris[$index]);
            }

            // Réécrit la ligne avec les nouveaux favoris
            $ligne[6] = implode(",", $favoris);
        }

        // Écrit la ligne dans le tampon
        $tampon.=implode(';',$ligne)."\n";
    }

    // Écrit le tampon dans le fichier, en écrasant le contenu précédent
    ftruncate($fichier,0);
    if (file_put_contents('comptes.csv', $tampon) === false) {
        echo "Erreur lors de l'écriture dans le fichier" ;
        fclose($fichier);
        return false;
    }

    // Ferme le fichier
    fclose($fichier);

    return true;
}


function existenceMail($email) {
    //On ouvre le fichier
    if (($handle = fopen('comptes.csv', "r")) !== FALSE) {
        
        //On parcours le csv
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            //Si on trouve le mail dans le csv, on referme le fichier et on renvoie true
            if ($data[3] == $email) {
                fclose($handle);
                return true;
            }
        }
        fclose($handle);
    }
    //Si l'on a parcouru toutes les lignes sans trouver le mail, on renvoie false
    return false;
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
            return false;
        }

        if(strpos($nom, ';') || strpos($prenom, ';') || strpos($email, ';') || strpos($mdp, ';')) {
            return false;
        }

        if(!strpos($email, '@')){
            return false;
        }

        if (existenceMail($email)==false){

            // Ouverture du fichier en mode écriture
            $file = fopen('comptes.csv', 'a');

            //On vérifie que le fichier s'est ouvert correctement
            if ($fichier==false){
                return "Fichier impossible à ouvrir";
            }
        
            // Génération d'un ID unique
            $id = uniqid();

            // Création d'une ligne au format CSV
            $line = "$id;$nom;$prenom;$email;$mdp;$admin;$fav\n";


            // Écriture de la ligne dans le fichier
            fwrite($file, $line);

            // Fermeture du fichier
            fclose($file);

            header('Location: connexion.php');
        }
        else{
            return false;
        }
    }
}

function login($email, $password) {
    // Vérification des informations de connexion
    $user_found = false;
    $handle = fopen('comptes.csv', 'r');

    //On vérifie que le fichier s'est ouvert correctement
    if ($handle==false){
        echo "Fichier impossible à ouvrir";
        exit;
    }

    if($handle !== FALSE) {
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
                break;
            }
        }
        fclose($handle);
    }
    return $user_found;
}

function connexion(){
    if(isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        if(login($email, $password)) {
            // Redirection vers la page d'accueil
            header('Location: accueil.html');
            exit;
        } else {
            // Affichage d'un message d'erreur
            $error = "Adresse e-mail ou mot de passe incorrect.";
        }
    }
}

function modifierCompte($nom, $prenom, $mail, $mdp) {
    // Vérification de l'existence de la session et du champ 'id' de l'utilisateur
    //if (isset($_SESSION['id'])) {
        // Récupération de l'identifiant de l'utilisateur
        //$id = $_SESSION['id'];
        $id='64394aabdedef';
    

        if(strpos($nom, ';') || strpos($prenom, ';') || strpos($mail, ';') || strpos($mdp, ';')) {
            echo "Les champs ne peuvent pas contenir le caractère (;) .";
            return false;
        }

        if(!strpos($mail, '@')&&!empty($mail)){
            echo "Le format du mail est invalide.";
            return false;
        }

        //Si le mail existe déjà dans le csv, l'opération est impossible
        if (existenceMail($mail)&&$mail!==$_SESSION['mail']){
            echo "Mail déjà existant.";
            return false;
        }

        //On crée un tampon qui nous permettra de réécrire le fichier en modifiant la ligne qui nous intéresse
        $tmp='';

        // Ouverture du fichier comptes.csv en lecture et écriture
        $fichier = fopen("comptes.csv", 'r+');

        //On vérifie que le fichier s'est ouvert correctement
        if ($fichier==false){
            echo "Fichier impossible à ouvrir";
            exit;
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
        try {
            ftruncate($fichier,0);
            if (file_put_contents('comptes.csv', $tmp) === false) {
                throw new Exception("Erreur lors de l'écriture dans le fichier");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        } finally {
            // Fermeture du fichier
            fclose($fichier);
        }

        return true;
    }
//}


//OBSOLETE
function supprimerUtilisateur($id)
{
    // Ouvrir le fichier CSV en mode lecture/écriture
    $fichier = fopen('comptes.csv', 'r+');

    //On vérifie que le fichier s'est ouvert correctement
    if ($fichier==false){
        echo "Fichier impossible à ouvrir";
        return false;
    }

    // Verrouiller le fichier pour empêcher les autres processus de le modifier
    flock($fichier, LOCK_EX);

    // Parcourir le fichier ligne par ligne
    while (($ligne = fgetcsv($fichier)) !== false) {
        // Vérifier si l'identifiant de l'utilisateur correspond
        if ($ligne[0] == $id) {
            // Se déplacer à la position du début de la ligne dans le fichier
            fseek($fichier, -ftell($fichier), SEEK_CUR);

            // Tronquer la ligne dans le fichier pour la supprimer
            ftruncate($fichier, ftell($fichier));

            // Déverrouiller le fichier et fermer la ressource
            flock($fichier, LOCK_UN);
            fclose($fichier);

            session_destroy();

            // Retourner vrai pour indiquer que la suppression a été effectuée avec succès
            return true;
        }
    }

    // Si l'identifiant de l'utilisateur n'a pas été trouvé, déverrouiller le fichier et fermer la ressource
    flock($fichier, LOCK_UN);
    fclose($fichier);

    // Retourner faux pour indiquer que la suppression a échoué
    return false;
}

function suppMonCompte(){
    if (isset($_SESSION['id'])){
        if (supprimerUtilisateur($_SESSION['id'])){
            header('Location: testconnexion.php');
            return true;
        }
    }
    else{
        return false;
    }
}

function test_session() {
    // Démarrer une session si aucune n'a été démarrée
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION['id_utilisateur'])) {
        //echo "L'id de l'utilisateur connecté est : " . $_SESSION['id_utilisateur'];
        return true;
    } else {
        //echo "Aucun utilisateur n'est connecté.";
        return false;
    }
}


function calculnoteG($idrecette){

    //On ouvre le fichier csv des commentaires, dans lequel sont enregistrées les notes
    $fichier=fopen('comm.csv','r');
    
    //On vérifie que le fichier s'est ouvert correctement
    if ($fichier==false){
        return -1;
    }

    //On initialise les variables qui serviront à calculer la moyenne
    $add=0;
    $cpt=0;

    //On parcourt le fichier pour faire une moyenne de toutes les notes trouvées pour une recette
    while (($ligne = fgetcsv($fichier,10000,';')) !== false){

        //On vérifie si la ligne correspond à la recette dont on veut calculer la note moyenne, et on ne prend en compte que les valeurs valides (vérification)
        if ($ligne[2]==$idrecette&&$ligne[5]<=5&&$ligne[5]>=0){
            //On incrémente le compteur et on ajoute la note au total si la condition est vérifiée
            $add+=$ligne[5];
            $cpt+=1;
        }
    }

    fclose($fichier);

    //Si le compteur est toujours à 0, aucune note n'a été trouvée
    if ($cpt==0){
        return -2;
    }
    else{
        $moy=$add/$cpt;
        return $moy;
    }
}

function modifiernote($idrecette){

    //On récupère la moyenne générale de la recette 
    $noteG=calculnoteG($idrecette);

    //Si le fichier n'a pas pu être ouvert, alors on ne fait rien
    if ($noteG==-1){
        echo "Erreur: Impossible d'ouvrir le fichier";
        return false;
    }

    //Si aucun commentaire n'a été trouvé, il n'y a rien à faire
    if ($noteG==-2){
        return true;
    }

    //On ouvre le fichier où sont stockées les données sur les recettes
    $file=fopen('stock.csv', 'r+');

    //On vérifie que le fichier s'est ouvert correctement
    if ($file==false){
        echo "Erreur: Impossible d'ouvrir le fichier.";
        return false;
    }

    //On crée un tampon qui nous permettra de réécrire le fichier en modifiant la ligne qui nous intéresse
    $tmp='';

    //On parcourt le fichier pour trouver la recette correspondante
    while (($ligne = fgetcsv($file,10000,';')) !== false){
        //On vérifie si la ligne où l'on est correspond à la recette dont on calcule la note
        if ($ligne[0]==$idrecette){

            //Si la recette a été trouvée, on remplace la note, et on arrête la boucle
            $ligne[4]=$noteG;
        }
        //On écrit dans le tampon la ligne modifiée ou non modifiée
        $tmp.=implode(';',$ligne)."\n";
    }

    //On efface le contenu du csv et on réécrit le tampon à la place, en vérifiant que l'écriture s'est effectuée avec succès
    ftruncate($file,0);
    if (file_put_contents('stock.csv', $tmp) === false) {
        echo "Erreur lors de l'écriture dans le fichier";
        return false;
    }

    // Fermeture du fichier
    fclose($file);

    return true;
}

function supprimerLigne($id, $com) {
    //Si l'id est vide il n'y a rien à faire
    if (empty($id)){
        return false;
    }

    // Ouvrir le fichier en mode lecture/écriture selon le mode choisi
    if ($com==1){
        $fichier = 'comm.csv';
    }
    else{
        $fichier = 'comptes.csv';
    }
    $fp = fopen($fichier, 'r+');

    // Verrouiller le fichier pour empêcher les autres processus de le modifier
    flock($fp, LOCK_EX);

    // Initialiser le tampon de sortie
    $tampon = '';

    // Parcourir chaque ligne du fichier
    while ($ligne = fgetcsv($fp, 10000, ';')) {
        // Si l'ID de la ligne correspond à l'ID à supprimer, passer à la ligne suivante
        if ($ligne[0] == $id) {
            //Si on doit supprimer un commentaire, on retient l'id de la recette dont la note est à mettre à jour
            if ($com==1){
                $idr=$ligne[2];
            }
            continue;
        }

        // Sinon, écrire la ligne dans le tampon de sortie
        $tampon .= implode(';', $ligne) . "\n";
    }

    // Écrire le tampon de sortie dans le fichier en écrasant son contenu
    ftruncate($fp,0);
    if (file_put_contents($fichier, $tampon)===false){
        fclose($fp);
        return false;
    }

    // Si on appelle la fonction pour supprimer un commentaire, il faut mettre à jour la moyenne
    if ($com==1){
        //On enlève le verrou pour modifier la note
        flock($fichier, LOCK_UN);
        $retour=modifiernote($idr);
        if ($retour==false){
            fclose($fp);
            return false;
        }
    }

    // Fermer le fichier
    fclose($fp);
    return true;
}


function addCom($idrecette){

    //Vérification que l'utilisateur est bien connecté
    //if (isset($_SESSION['id_utilisateur'])){

        //Vérification que le formulaire a été soumis
        //if (isset($_POST['submit'])){

            //On récupère les données du formulaire
            $titre=$_POST['titre'];
            $comm=$_POST['comm'];
            $note=$_POST['note'];

            if(empty($titre) || empty($note)) {
                echo "Le commentaire doit au minimum contenir un titre et une note.";
                return false;
            }

            if(strpos($titre, ';') || strpos($comm, ';') || strpos($note, ';')) {
                echo "Les champs ne peuvent pas contenir le caractère (;) .";
                return false;
            }

            if(!is_numeric($note)){
                echo "La note doit être un entier entre 0 et 5 compris.";
                return false;
            }

            if($note>5||$note<0){
                echo "La note doit être un entier entre 0 et 5 compris.";
                return false;
            }

            if (!existeid($idrecette,'stock.csv')){
                echo "Erreur: Cette recette n'existe pas.";
                return false;
            }

            //On ouvre le csv où sont enregistrés les commentaires
            $file=fopen('comm.csv','a');

            //On vérifie que le fichier s'est ouvert correctement
            if ($file==false){
                echo "Fichier impossible à ouvrir";
                return false;
            }

            //On attribue un id unique au commentaire
            $id=uniqid();

            //On récupère l'id de l'utilisateur dont la session est en cours
            $iduser='6435ab1929615';//$_SESSION['id_utilisateur'];

            //On écrit la ligne dans le csv
            $line="$id;$iduser;$idrecette;$titre;$comm;$note\n";
            fwrite($file,$line);

            //Fermeture du fichier
            fclose($file);

            //$verifnote=modifiernote($idrecette);
            //if ($verifnote==false){
            //    echo 'Erreur: Mise à jour de la note impossible.'
            //}
            return true;
        //}
    //}

    //Si l'utilisateur n'est pas connecté, on le renvoie vers la page de connexion
    //else{
    //    header('Location: connexion.php');
    //    return False;
    //}
}


//OBSOLETE
function supprimer_commentaire($idcomm){
    // Ouverture du fichier CSV
    $fichier = fopen('comm.csv', 'r+');

    //On vérifie que le fichier s'est ouvert correctement
    if ($fichier==false){
        echo "Fichier impossible à ouvrir";
        exit;
    }

    // Lecture des données ligne par ligne
    while (($ligne = fgetcsv($fichier, 10000, ';')) !== FALSE) {
        // Si l'id du commentaire correspond à celui recherché, on supprime la ligne
        if ($ligne[0] == $idcomm) {
            fseek($fichier, -strlen(implode(';', $ligne)), SEEK_CUR);
            fputs($fichier, str_repeat(' ', strlen(implode(';', $ligne))));
            fseek($fichier, -strlen(implode(';', $ligne)), SEEK_CUR);
            fclose($fichier);
            return true;
        }
    }
    fclose($fichier);
    return false;
}

function isadmin() {
    //On vérifie qu'une session est bien lancée et que l'utilisateur est connecté
    if (test_session()){
        //On vérifie si l'utilisateur dont la session est ouverte est un administrateur
        if ($_SESSION['admin']!==0){
            return true;
        }
        else{
            return false;
        }
    }
    else{
        return false;
    }
}

function recherchemeilleurenote() {

    // Ouverture du fichier CSV
    $fichier = fopen('stock.csv', 'r+');

    //On vérifie que le fichier s'est ouvert correctement
    if ($fichier==false){
        echo "Fichier impossible à ouvrir";
        exit;
    }

    //On instancie la meilleure note à -1, qui est une note impossible
    $mnote=-1;

    // Lecture des données ligne par ligne
    while (($ligne = fgetcsv($fichier, 10000, ';')) !== FALSE) {
        //On sépare le format de la date
        $time = explode('/',$ligne[6]);

        //On vérifie que la recette a bien été publié dans le mois
        if ($time[2]==date("Y") && $time[1]==date("m")) {
            //On vérifie si la note est meilleure
            if ($mnote<$ligne[4]) {

                //Si la note est meilleure, on l'enregistre, ainsi que l'id de la recette correspondante
                $mnote=$ligne[4];
                $mrecette=$ligne[0];
            }
        }
    }

    //On ferme le fichier
    fclose($fichier);

    //Si on a toujours la meilleure note à -1, c'est qu'aucune recette n'a été publiée dans le mois
    if ($mnote==-1){
        return false;
    }

    //On retourne l'id de la recette publié dans le mois dont la note est la meilleure
    return $mrecette;
}

function recherche($mots_cles){

    //On vérifie que la chaîne en paramètres n'est pas vide
    if (empty($mots_cles)){
        return false;
    } 

    //On transforme la chaîne en tableaux
    $tab=explode(' ',$mots_cles);

    //Ouverture du fichier stock.csv en lecture
    $fichier = fopen('stock.csv', 'r');

    //On vérifie que le fichier s'est ouvert correctement
    if ($fichier==false){
        echo "Fichier impossible à ouvrir";
        exit;
    }

    //Initialisation des tableaux de stockage des résultats et de leur score respectif
    $resultats = [];
    $scores = [];

    //Lecture des lignes du fichier
    while (($ligne = fgetcsv($fichier, 10000, ';')) !== false){

        //On passe les lignes vides
        if (empty($ligne)){
            continue;
        }

        //On récupère les colonnes qui nous intéressent et on initialise le score de chaque ligne
        $titre = $ligne[7]; 
        $score = 0;
        $description = $ligne[1]; 

        //On vérifie chaque mot clé
        foreach($tab as $mot){
            //on vérifie la présence de chaque mot clé dans le titre
            if(strpos(strtolower($titre), strtolower($mot)) !== false){  
                //on incrémente le score de 3 si le mot clé est trouvé dans le titre (le titre est plus important)               
                $score+=3; 
            }

            //on vérifie la présence de chaque mot clé dans la description
            if(strpos(strtolower($description), strtolower($mot)) !== false){
                $score++; 
            }
        }


        //Si la recette contient au moins un des mots clés, on l'ajoute aux résultats avec son score total
        if($score > 0){
            $resultats[] = $ligne[0]; //on ajoute l'identifiant de la recette
            $scores[] = $score; //on ajoute le score total de la recette
        }
    }

    //Si le tableau contenant tous les scores est vide, on renvoie false car le mot clé n'est dans aucun titre ni description
    if (empty($scores)){
        return false;
    }

    //Fermeture du fichier
    fclose($fichier);

    //Tri des résultats en fonction du score (en ordre décroissant)
    array_multisort($scores, SORT_DESC, $resultats);

    //Retour des identifiants des recettes triés par score
    return $resultats;
}


?>
