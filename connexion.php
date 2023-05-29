<?php
session_start();
?>



<!DOCTYPE html>
<html lang="fr">
<head>
  <link rel="stylesheet" href="connexion.css">
  <title>BeautyMix • Connexion</title>
</head>
<body>
    <script>// Vérifier si le cookie "user_logged_in" est défini
        if (document.cookie.indexOf('user_logged_in=true') !== -1) {
            // Rediriger vers le compte si déjà connecté
            if (document.cookie.indexOf('admin=true') !== -1) {
                window.location.href = 'moncompteadmin.php';
            }
            else{
                window.location.href = 'moncompte.php';
            }
        }
        </script>
    <section>
        <div class="form-box">
            <div class="form-value">
                <h2>Connexion</h2>
                <div id='erreur'></div>
                <form id="form" action="connexionfct.php" method="post">
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input name="email" id="email" type="email" required>
                        <label for="">Adresse mail</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input name="password" id="password" type="password" required>
                        <label for="">Mot de passe</label>
                    </div>
                    <button type="submit">Se connecter</button>
                </form>
                <div class="register">
                    <p>Vous n'avez pas de compte? <a href="inscription.php">Créez-en un!</a></p>
                </div>
            </div>
        </div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="connexion.js"></script>
</body>
</html>