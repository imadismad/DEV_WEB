function supprimerLigne($id, $com) {
    //Si l'id est vide il n'y a rien à faire
    if (empty($id)){
        return false;
    }

    // Ouvrir le fichier en mode lecture/écriture selon le mode choisi
    if ($com==1){
        $fichier = 'comm.csv';
    }
    else if ($com==2){
        $fichier = 'stock.csv';
    }
    else{
        $fichier = 'comptes.csv';
    }
    $fp = fopen($fichier, 'r+');

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