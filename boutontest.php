<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
<body>
    <t3>Ajout favoris</t3>
    <form action="ajoutfavoris.php" method="post">
        <input type="text" name="idrecette">
        <br>
        <input type="text" name="iduser">
        <br>
        <input type="submit">
    </form>
    <br> <br> <br>
    <t3>Supp favoris</t3>
    <form action="suppfavori2.php" method="post">
        <input type="text" name="idrecette">
        <br>
        <input type="text" name="iduser">
        <br>
        <input type="submit">
    </form>
    <br> <br> <br>
    <t3>Recherche mots clés</t3>
    <form action="recherche.php" method="post">
        <input type="text" name="motsclefs">
        <br>
        <input type="submit">
    </form>
    <br>
    <br>
    <br>
    <t3>Modif compte</t3>
    <form action="nvllcoor.php" method="post">
        <input type="text" name="nom" placeholder="nom">
        <br>
        <input type="text" name="prenom" placeholder="prenom">
        <br>
        <input type="text" name="mail" placeholder="mail">
        <br>
        <input type="password" name="mdp" placeholder="mdp">
        <br>
        <input type="submit">
    </form>
    <br><br><br>
    <t3>Suppression</t3>
    <form action="supprimer.php" method="post">
        <input type="text" name="id">
        <br>
        <input type="submit">
    </form>
    <br>
    <br>
    <br>
    <t3>Add comm</t3>
    <form action="ajoutercomm.php" method="post">
        <input type="text" name="titre" placeholder="titre">
        <br>
        <input type="text" name="comm" placeholder="comm">
        <br>
        <input type="text" name="note" placeholder="note">
        <br>
        <input type="submit">
    </form>
    <br><br><br>
    <t3>Test meilleure recette</t3>
    <form action="classement.php" method="post">
        <input type="submit">
    </form>
    <br><br><br>
    <t3>Test maj note</t3>
    <form action="testnote.php" method="post">
        <input type="submit">
    </form>
</body>
</html>