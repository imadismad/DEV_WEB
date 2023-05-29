<?php

require_once 'utilitaire.php';

function ajouterFavori($id, $produit_id) {
    if(!existeFavori($id,$produit_id)&&existeid($id,'comptes.csv')&&existeid($produit_id,'stock.csv')){
        // Récupération du contenu du fichier CSV
        $file = file_get_contents('comptes.csv');

        //On vérifie que le fichier s'est ouvert correctement
        if (empty($file)){
            return "Erreur: Ouverture du fichier impossible.";
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
        return "success";
    }
}

function supprimerFavori($iduser, $idproduit) {

    if (empty($iduser) || empty($idproduit)) {
        return "Erreur: paramètres vides.";
    }

    // Ouvre le fichier en mode lecture et écriture
    $fichier = fopen('comptes.csv', "r+");

    // On vérifie que le fichier s'est ouvert correctement
    if ($fichier == false) {
        return "Fichier impossible à ouvrir";
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
        fclose($fichier);
        return "Erreur lors de l'écriture dans le fichier" ;
    }

    // Ferme le fichier
    fclose($fichier);

    return "success";
}

?>