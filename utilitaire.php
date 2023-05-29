<?php

include_once 'commfonctions.php';

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
        if (strpos($line,$id)!==false){
            return true;
        }
    }

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


function supprimerLigne($id, $fichier) {
    if (empty($id) || empty($fichier)) {
      return false;
    }
  
    $file = file($fichier);
    $tampon = '';
  
    foreach ($file as $ligne) {
      if (strpos($ligne, $id) !== false) {
        if ($fichier=="comm.csv"){
            $fields = explode(";", $ligne);
            $idr=$fields[2];
        }
        continue;
      }
      $tampon .= $ligne;
    }
  
    if (file_put_contents($fichier, $tampon) !== false) {
      if (!empty($idr)){
        $retour=modifiernote($idr);
        if ($retour==false){
            return $idr;
        }
        return 1;
      }
      return true;
    }
  
    return false;
  }

function getRowsByIds($csvFile, $ids) {
    $rows = array();

    //On parcourt le tableau 
    if (($handle = fopen($csvFile, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

            //Si l'id de la ligne est bien dans les id recherché, on rajoute la ligne au tableau $rows
            if (in_array($data[0], $ids)) {
                $rows[] = $data;
            }
        }
        fclose($handle);
    }

    return $rows;
}


?>