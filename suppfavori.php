<?php

include_once 'verifs.php';

$id=$_POST['iduser'];
$idp=$_POST['idrecette'];


function supprimerFavori($iduser, $idproduit) {

    if (empty($iduser) || empty($idproduit)) {
        echo "Erreur: paramètres vides.";
        return false;
    }

    $fichier = fopen('comptes.csv', "r+");
    if ($fichier === false) {
        echo "Fichier impossible à ouvrir";
        return false;
    }

    // Verrouillage du fichier
    flock($fichier, LOCK_EX);

    // Parcours chaque ligne du fichier
    while (($ligne = fgetcsv($fichier, 10000, ";")) !== false) {
        echo "$ligne[0] == $iduser";
        //Si l'ID utilisateur correspond
        if ($ligne[0] == $iduser){
            echo "oui";
            // Récupère les favoris actuels
            $favoris = explode(",", $ligne[6]);

            // Supprime le produit de la liste des favoris
            $index = 0; 
            foreach($favoris as $favori){
                if (strpos($favori,$idproduit)!==false){
                    unset($favoris[$index]);
                    break;
                }
                $index+=1;
            }

            //On calcule la nouvelle ligne avec les nouveaux favoris
            $ligne_modifiee = implode(';', array_slice($ligne, 0, 6)) . ';' . implode(',', $favoris) ;

            //On se déplace au début de la ligne
            fseek($fichier, -strlen(implode(';', $ligne))-1, SEEK_CUR);

            //On écrit la ligne modifiée
            fwrite($fichier, $ligne_modifiee);

            // On remplit la ligne avec des espaces si nécessaire
            $longueur_ligne_modifiee = strlen($ligne_modifiee);
            $longueur_ligne_originale = strlen(implode(';', $ligne));
            if ($longueur_ligne_modifiee < $longueur_ligne_originale) {
                fwrite($fichier, str_repeat(" ", $longueur_ligne_originale - $longueur_ligne_modifiee));
            }

            break;
        }
    }

    // Déverrouillage du fichier
    flock($fichier, LOCK_UN);

    fclose($fichier);

    return true;
}

supprimerFavori($id, $idp);

?>