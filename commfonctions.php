<?php

require_once 'utilitaire.php';

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

function addCom(){

    $idrecette=$_POST['idrecette'];

    //Vérification que l'utilisateur est bien connecté
    if (isset($_SESSION['id_utilisateur'])){

        //Vérification que le formulaire a été soumis
        if (isset($_POST['submit'])){

            //On récupère les données du formulaire
            $titre=$_POST['titre'];
            $comm=$_POST['comm'];
            $note=$_POST['note'];

            if(empty($titre) || empty($note)) {
                return "Le commentaire doit au minimum contenir un titre et une note.";
            }

            if(strpos($titre, ';') || strpos($comm, ';') || strpos($note, ';')) {
                return "Les champs ne peuvent pas contenir le caractère (;) .";
            }

            if(!is_numeric($note)){
                return "La note doit être un entier entre 0 et 5 compris.";
            }

            if($note>5||$note<0){
                return "La note doit être un entier entre 0 et 5 compris.";
            }

            if (!existeid($idrecette,'stock.csv')){
                echo "Erreur: Cette recette n'existe pas.";
                return false;
            }

            //On ouvre le csv où sont enregistrés les commentaires
            $file=fopen('comm.csv','a');

            //On vérifie que le fichier s'est ouvert correctement
            if ($file==false){
                return "Fichier impossible à ouvrir";
            }

            //On attribue un id unique au commentaire
            $id=uniqid();

            //On récupère l'id de l'utilisateur dont la session est en cours
            $iduser=$_SESSION['id_utilisateur'];

            //On écrit la ligne dans le csv
            $line="$id;$iduser;$idrecette;$titre;$comm;$note\n";
            fwrite($file,$line);

            //Fermeture du fichier
            fclose($file);

            $verifnote=modifiernote($idrecette);
            if ($verifnote==false){
                return 'Erreur: Mise à jour de la note impossible.';
            }
            return "success";
        }
    }

    //Si l'utilisateur n'est pas connecté, on le renvoie vers la page de connexion
    else{
        header('Location: connexion.php');
        return False;
    }
}

?>