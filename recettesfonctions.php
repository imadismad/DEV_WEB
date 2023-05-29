<?php

require_once 'utilitaire.php';

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