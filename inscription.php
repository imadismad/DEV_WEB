<?php
session_start();
?>



<!DOCTYPE html>
<html lang="fr">
<head>
  <link rel="stylesheet" href="inscription.css">
  <title>BeautyMix • Inscription</title>
</head>
<body>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form action="inscriptionfct.php" method="post" id="mon-formulaire">
                    <h2>Inscription</h2>
                    <div id="erreur"></div>
                    <div class="inputbox">
                        <ion-icon name="person-outline"></ion-icon>
                        <input name="surname" id="surname" type="person-outline" required>
                        <label for="">Nom</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="person-outline"></ion-icon>
                        <input name="name" id="name" type="text" required>
                        <label for="">Prénom</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input name="email" id="email" type="email" required>
                        <label for="">Adresse mail</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input name="password" id="password" type="password" required>
                        <label for="">Nouveau mot de passe</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input name="verifpassword" id="verifpassword" type="password" required>
                        <label for="">Confirmer mot de passe</label>
                    </div>
                    <button type='submit'>Créer le compte</button>
                </form>
                <div class="connect">
                    <p>Vous avez un compte? <a href="connexion.php">Connectez-vous!</a></p>
                </div>
            </div>
        </div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="inscription.js"></script>
</body>
</html>